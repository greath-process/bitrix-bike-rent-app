<?php
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application,
    Bitrix\Main,
    Bitrix\Main\Context;
global $APPLICATION;
CModule::IncludeModule('iblock');

unset($_SESSION["prod_arr"]);

$request = Application::getInstance()->getContext()->getRequest();
$data = $request->getPostList()->toArray();

$arErrors = [];
$arResponse = [];

/* данные из формы */
$arFields = $data;

/* ошибки */
if (empty($data['ORDER_ID'])) {
    $arErrors[] = 'Заказ не найден';
}
if (empty($data['ITEMS'])) {
    $arErrors[] = 'Нет товаров в заказе.';
}

if (empty($arErrors)) {
    if($data["PAID"] == "Y") {
        $paid = 35; // ид значение оплаты
        $paid_status = "оплачен";
    }
    else {
        $paid = '';
        $paid_status = "не оплачен";
    }

    $newArr = array(
        "STATUS" => $data["STATUS"],
        "PAID" => $paid,
        "ITEMS" => $data["ITEMS"],
        "PRICE" => $data["PRICE"],
        "PAYMENT_SYSTEM" => $data["PAYMENT_SYSTEM"],
        "DELIVERY" => $data["DELIVERY"],
        "ADDRESS_DELIVERY" => $data["ADDRESS_DELIVERY"],
        "ADDRESS_RETURN" => $data["ADDRESS_RETURN"],
        "ADMIN_COMMENT" => $data["ADMIN_COMMENT"],
    );
    CIBlockElement::SetPropertyValuesEx($data['ORDER_ID'], false, $newArr);

    /* Отправка письма на почту */
    $res = CIBlockElement::GetByID($data['ORDER_ID']);
    if ($ar_res = $res->Fetch())
        $orderDate = $ar_res['DATE_CREATE'];

    $propFilter = array(
        ">ID" => 1,
    );
    $propsDbres = CIBlockElement::GetProperty(ORDER_IBLOCK, $data['ORDER_ID'], "sort", "asc", $propFilter);
    while ($ob = $propsDbres->GetNext()) {
        $fileds[$ob["CODE"]] = $ob;
    }

    /* user */
    $rsUser = CUser::GetByID($fileds['USER']['VALUE']);
    $arUser = $rsUser->Fetch();

    $arFields = array(
        "DATE_START" => $fileds['DATE_START']['VALUE'],
        "DATE_END" => $fileds['DATE_END']['VALUE'],
        "DATE_RETURN" => $fileds['DATE_RETURN']['VALUE'],
        'ORDER_ID' => $data['ORDER_ID'],
        'ORDER_DATE' => $orderDate,
        "USER" => $fileds['USER']['VALUE'],
        "EMAIL" => $arUser['EMAIL'],
        "PHONE" => $arUser['PERSONAL_PHONE'],
        "USER_NAME" => $arUser['NAME'],
        "HELMET"=> $fileds['HELMET']['VALUE'],
        "LIGHTER"=> $fileds['LIGHTER']['VALUE'],
        "LOCK"=> $fileds['LOCK']['VALUE'],
        "PAID" => $paid_status,
        "PRICE" => $data["PRICE"],
        "ADDRESS_DELIVERY" => $data["ADDRESS_DELIVERY"],
        "ADDRESS_RETURN" => $fileds["ADDRESS_RETURN"]['VALUE'],
        "ADMIN_COMMENT" => $data["ADMIN_COMMENT"],
    );

    /* товары в заказе */
    $strCustomOrderList = '<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
    <thead><p style="font-weight: bold;font-size: 18px;text-align: center;margin: 0;width: 200%;background: #f7f7f7;"> Состав заказа:</p>';
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID"=>RENT_IBLOCK, "ID"=>$data["ITEMS"]);
    $rsItems = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
    $first = true;
    while($Item = $rsItems->GetNextElement()) {
        $ItFields = $Item->GetFields();
        $arProps = $Item->GetProperties();
        $price = $arProps['PRICE_FOR_'.strtoupper($arFields["TYPE_AREND"])]['VALUE'];
        if($first){
            $strCustomOrderList .='<tr><th style="font-size: 16px;padding: 5px;font-weight: bold;">Название</th><th style="font-size: 16px;padding: 5px;font-weight: bold;">'.$arProps['PRICE_FOR_'.strtoupper($arFields["TYPE_AREND"])]["NAME"].'</th></tr></thead><tbody>';
        }
        $strCustomOrderList .= '<tr><td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #000; width: 50%;">'.$ItFields['NAME'].'</td><td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #000;" align="center">'.$price.'</td><tr>';
        $first = false;
    }
    $strCustomOrderList .= '<tbody></table>';

    /* Доставка */
    $entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
    $rsData = $entity_data_class::getList(array(
        'select' => array('*'),
        'order' => array('UF_SORT' => 'ASC'),
        'filter' => array('UF_XML_ID'=> $data['DELIVERY'])
    ));
    if ($el = $rsData->fetch()) {
        $delivery_name = $el["UF_NAME"];
    }

    /* Оплата */
    $entity_data_class = GetEntityDataClass(HLB_PAYMENT_ID);
    $rsData = $entity_data_class::getList(array(
        'select' => array('*'),
        'order' => array('UF_SORT' => 'ASC'),
        'filter' => array('UF_XML_ID'=> $data['PAYMENT_SYSTEM'])
    ));
    if ($el = $rsData->fetch()) {
        $payment_name = $el["UF_NAME"];
    }

    $arFields["ITEMS"] = $strCustomOrderList;
    $arFields["ORDER_DATE"] = $orderDate;
    $arFields["TYPE_AREND"] = ($data['TYPE_AREND'] == "hours") ? "по 2 часа" : "По дням";
    $arFields["PAYMENT_SYSTEM"] = $payment_name;
    $arFields["DELIVERY"] = $delivery_name;

    $res = CIBlockElement::GetByID( $fileds['STATUS']['VALUE']);
    if($ar_res = $res->GetNext())
        $status = $ar_res['NAME'];
    $arFields["STATUS"] = $status;

    CEvent::Send("ORDER_CHANGE", SITE_ID, $arFields); // отправляем поля

    ob_start();
    $APPLICATION->IncludeComponent(
        "bitrix:news.detail",
        "admin_order_view",
        array(
            "ACTIVE_DATE_FORMAT" => "d.m.Y",
            "ADD_ELEMENT_CHAIN" => "N",
            "ADD_SECTIONS_CHAIN" => "N",
            "AJAX_MODE" => "N",
            "AJAX_OPTION_ADDITIONAL" => "",
            "AJAX_OPTION_HISTORY" => "N",
            "AJAX_OPTION_JUMP" => "N",
            "AJAX_OPTION_STYLE" => "Y",
            "BROWSER_TITLE" => "-",
            "CACHE_GROUPS" => "Y",
            "CACHE_TIME" => "0",
            "CACHE_TYPE" => "N",
            "CHECK_DATES" => "Y",
            "DETAIL_URL" => "",
            "DISPLAY_BOTTOM_PAGER" => "N",
            "DISPLAY_DATE" => "Y",
            "DISPLAY_NAME" => "Y",
            "DISPLAY_PICTURE" => "Y",
            "DISPLAY_PREVIEW_TEXT" => "Y",
            "DISPLAY_TOP_PAGER" => "N",
            "ELEMENT_CODE" => "",
            "ELEMENT_ID" => $_POST["ORDER_ID"],
            "FIELD_CODE" => array(0 => "NAME", 1 => "",),
            "IBLOCK_ID" => ORDER_IBLOCK,
            "IBLOCK_TYPE" => "catalogs",
            "IBLOCK_URL" => "",
            "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
            "MESSAGE_404" => "",
            "META_DESCRIPTION" => "-",
            "META_KEYWORDS" => "-",
            "PAGER_BASE_LINK_ENABLE" => "N",
            "PAGER_SHOW_ALL" => "N",
            "PAGER_TEMPLATE" => ".default",
            "PAGER_TITLE" => "Страница",
            "PROPERTY_CODE" => array(0 => "DATE_START", 1 => "DATE_END", 2 => "DATE_RETURN", 3 => "ADDRESS_RETURN", 4 => "ADDRESS_DELIVERY", 5 => "HELMET", 6 => "LIGHTER", 7 => "LOCK", 8 => "USER", 9 => "USER_NAME", 10 => "PHONE", 11 => "TYPE_AREND", 12 => "ADMIN_COMMENT", 13 => "PAYMENT_SYSTEM", 14 => "DELIVERY", 15 => "PRICE", 16 => "PRICE_DELIVERY", 17 => "PAID", 18 => "",),
            "SET_BROWSER_TITLE" => "N",
            "SET_CANONICAL_URL" => "N",
            "SET_LAST_MODIFIED" => "N",
            "SET_META_DESCRIPTION" => "N",
            "SET_META_KEYWORDS" => "N",
            "SET_STATUS_404" => "N",
            "SET_TITLE" => "N",
            "SHOW_404" => "N",
            "STRICT_SECTION_CHECK" => "N",
            "USE_PERMISSIONS" => "N",
            "USE_SHARE" => "N"
        )
    );
    $d = ob_get_clean();
    $arResponse = [
        'STATUS' => 'success',
        'MESSAGE' => 'изменения успешно сохранены!',
        'HTML' => $d,
        'prop'=>$fileds
    ];
} else {
    $arResponse = [
        'STATUS' => 'error',
        'ERRORS' => $arErrors,
    ];
}

echo Bitrix\Main\Web\Json::encode($arResponse);
