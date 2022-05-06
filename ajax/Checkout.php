<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application,
    Bitrix\Main,
    Bitrix\Main\Localization\Loc as Loc,
    Bitrix\Main\Context;

global $USER;

$request = Application::getInstance()->getContext()->getRequest();
$data = $request->getPostList()->toArray();

$arErrors = [];
$arResponse = [];

/* ошибки */
//if (empty($data['USER_NAME'])) {
//    $arErrors[] = 'Заполните поле "Имя"';
//}
//if (empty($data['PHONE'])) {
//    $arErrors[] = 'Заполните поле "Телефон"';
//}

/* данные из формы */
//$data["DATE_RETURN"] = "";
$arFields = $data;


/* данные из сессии */
$arFields["ITEMS"] = $_SESSION["prod_arr"]; // ид товаров
$arFields["DATE_START"] = $_SESSION["data_start"]; // дата начала аренды
$arFields["DATE_END"] = $_SESSION["data_end"]; // дата конца аренды
$arFields["TYPE_AREND"] = $_SESSION["param__arend"]; // тип аренды
$arFields["DELIVERY"] = $_SESSION["type_delivery"]; // тип доставки
if(explode(' ',$arFields["DATE_RETURN"])[1] == "00:00")
    $arFields["DATE_RETURN"] = $_SESSION["data_end"];

/* если интервали пересекаются - "Занят" */
$start = date_create_from_format('d.m.Y H:i', $_SESSION["data_start"]);
$end = date_create_from_format('d.m.Y H:i',$_SESSION["data_end"]);
$start = date_format($start,"Y-m-d");
$end = date_format($end,"Y-m-d")." 23:59:59";

$arSelect = Array("ID", "IBLOCK_ID", "DATE_ACTIVE_FROM", "PROPERTY_DATE_START", "PROPERTY_DATE_END");
$arFilter = Array(
    "IBLOCK_ID"=>ORDER_IBLOCK,
    "PROPERTY_ITEMS" => $_SESSION["prod_arr"],
    "!PROPERTY_STATUS" => array(CANCEL_STATUS, COMPLETE_STATUS),
    array(
        'LOGIC' => 'OR',
        array(
            ">=PROPERTY_DATE_START" => $start,
            "<=PROPERTY_DATE_START" => $end,
        ),
        array(
            ">=PROPERTY_DATE_END" => $start,
            "<=PROPERTY_DATE_END" => $end,
        ),
    ),
);
$rsItems = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($Item = $rsItems->GetNextElement()) {
    $arFields = $Item->GetFields();
    $arProps = $Item->GetProperties();
    $arErrors[] = "The item is already taken. Please go back to the main page and make another order.";
    unset($_SESSION["prod_arr"]);
}

/* Доставка */
$entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'order' => array('UF_SORT' => 'ASC'),
    'filter' => array('UF_XML_ID'=> $arFields['DELIVERY'])
));
if ($el = $rsData->fetch()) {
    $delivery_name = $el["UF_NAME"];
}

/* Оплата */
$entity_data_class = GetEntityDataClass(HLB_PAYMENT_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'order' => array('UF_SORT' => 'ASC'),
    'filter' => array('UF_XML_ID'=> $arFields['PAYMENT_SYSTEM'])
));
if ($el = $rsData->fetch()) {
    $payment_name = $el["UF_NAME"];
}
/* если оплачен */
if($data["PAID"] == "Y")
    $arFields["PAID"] = "Y";

if(empty($arErrors)) {
    /* доп. данные */
    if ($USER->IsAuthorized()) {
        $userID = $USER->GetID();
    } else {/* АВТОРЕГИСТРАЦИЯ */
        $name = $data["USER_NAME"];
        $email = $data["EMAIL"];
        $phone = \NormalizePhone($data["PHONE"]);
        $address = empty($data["ADDRESS_DELIVERY"]) ? '' : $data["ADDRESS_DELIVERY"];
//    $login = strpos($email, '@');
        $login = $data["PHONE"];
        $userID = registerUserByPhone($phone, $email, $name, $address);
        if (intval($userID) > 0)
            $USER->Authorize($userID);
        else
            $arErrors[] = $userID;
    }
}

$arFields["USER"] = $userID; // ид пользователя
$arFields["STATUS"] = DEFAULT_STATUS; // статус в обработке

if (empty($arErrors)) {
    CModule::IncludeModule('iblock');
    $el = new CIBlockElement;                   // создаем новый элемент ИБ

    $arLoadProductArray = Array(
        "IBLOCK_ID"      => ORDER_IBLOCK,       // id нужного инфоблока
        "PROPERTY_VALUES"=> $arFields,          // массив свойств
        "NAME"           => date("d.m.Y H:i:s"), // название элемента03.08.2021 18:54:00
        "ACTIVE"         => "Y",                // активность элемента
    );

    $PRODUCT_ID = $el->Add($arLoadProductArray);   // создаем ИБ с этими полями

    if (!$PRODUCT_ID) {
        $arErrors[] = $el->LAST_ERROR;
    }

    /****Подготовка полей для отправки письма ****/
    /* товары в заказе */
    $strCustomOrderList = '<table cellpadding="0" cellspacing="0" width="850" style="background-color: #d1d1d1; border-radius: 2px; border:1px solid #d1d1d1; margin: 0 auto;" border="1" bordercolor="#d1d1d1">
    <thead><p style="font-weight: bold;font-size: 18px;text-align: center;margin: 0;width: 200%;background: #f7f7f7;"> Order list:</p>';
    $arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM", "PROPERTY_*");
    $arFilter = Array("IBLOCK_ID"=>RENT_IBLOCK, "ID"=>$arFields["ITEMS"]);
    $rsItems = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
    $first = true;
    while($Item = $rsItems->GetNextElement()) {
        $ItFields = $Item->GetFields();
        $arProps = $Item->GetProperties();
        $price = $arProps['PRICE_FOR_'.strtoupper($arFields["TYPE_AREND"])]['VALUE'];
        if($first){
            $strCustomOrderList .='<tr><th style="font-size: 16px;padding: 5px;font-weight: bold;">Name</th><th style="font-size: 16px;padding: 5px;font-weight: bold;">'.$arProps['PRICE_FOR_'.strtoupper($arFields["TYPE_AREND"])]["NAME"].'</th></tr></thead><tbody>';
        }
        $strCustomOrderList .= '<tr><td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #000; width: 50%;">'.$ItFields['NAME'].'</td><td style="font-size: 16px; line-height: 20px; font-weight: 400; color: #000;" align="center">'.$price.'</td><tr>';
        $first = false;
    }
    $strCustomOrderList .= '<tbody></table>';


    $arFields["ITEMS"] = $strCustomOrderList;
    $arFields["ORDER_ID"] = $PRODUCT_ID;
    $arFields["ORDER_DATE"] = date("d.m.Y H:i:s");
    $arFields["TYPE_AREND"] = ($arFields['TYPE_AREND'] == "hours") ? "2 hours" : "By days";
    $arFields["PAYMENT_SYSTEM"] = $payment_name;
    $arFields["DELIVERY"] = $delivery_name;

    /* отправка письма */
    CEvent::Send("ORDER_FORM", SITE_ID, $arFields); // отправляем поля

    $arResponse = [
        'STATUS' => 'success',
        'ORDER_ID' => intval($PRODUCT_ID),
    ];
    unset($_SESSION["prod_arr"]); // ид товаров
    unset($_SESSION["data_start"]); // дата начала аренды
    unset($_SESSION["data_end"]); // дата конца аренды
    unset($_SESSION["param__arend"]); // тип аренды
    unset($_SESSION["type_delivery"]); // тип доставки
    unset($_SESSION["sections"]); // выбранные категории
    unset($_SESSION["additional"]); // выбранные доп. свойства
    unset($_SESSION["payment"]); // выбранные доп. свойства
    unset($_SESSION["ORDER_FIELDS"]); // введенные данные
} else {
    $arResponse = [
        'STATUS' => 'error',
        'ERRORS' => $arErrors,
    ];
}

echo Bitrix\Main\Web\Json::encode($arResponse);
die();
