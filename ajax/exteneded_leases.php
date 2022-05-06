<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
global $USER;

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


if (empty($arErrors)) {
    CModule::IncludeModule('iblock');
    $el = new CIBlockElement;                   // создаем новый элемент ИБ

    $arLoadProductArray = Array(
        "IBLOCK_ID"      => EXETENDED_IBLOCK,                  // id нужного инфоблока
        "PROPERTY_VALUES"=> $arFields,                     // массив свойств
        "NAME"           => date("d.m.Y H:i:s"),    // название элемента
        "ACTIVE"         => "Y",                          // активность элемента
    );

    $PRODUCT_ID = $el->Add($arLoadProductArray);   // создаем ИБ с этими полями

    if (!$PRODUCT_ID) {
        $arErrors[] = $el->LAST_ERROR;
    }

    /* отправка письма */
    $arFields["TYPE_AREND"] = ($arFields['TYPE_AREND'] == "days") ? "По дням" : "по 2 часа";
    $arFields["PAID"] = ($data["PAID"] == "Y") ? "оплачен" : "не оплачен";
    $arFields['PAYMENT_SYSTEM'] = $payment_name;
    $arFields['REQUEST_ID'] = $PRODUCT_ID;

    CEvent::Send("EXTENDED_LEASE", SITE_ID, $arFields);     // отправляем поля

    $arResponse = [
        'STATUS' => 'success',
        'ERRORS' => $arErrors,
    ];

} else {
    $arResponse = [
        'STATUS' => 'error',
        'ERRORS' => $arErrors,
    ];
}

echo Bitrix\Main\Web\Json::encode($arResponse);
//die();
