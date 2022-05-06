<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

use Bitrix\Main\Application;
global $USER;

$request = Application::getInstance()->getContext()->getRequest();
$data = $request->getPostList()->toArray();

$arErrors = [];
$arResponse = [];

/* ошибки */
if (empty($data['NAME'])) {
    $arErrors[] = 'Заполните поле "Имя"';
}
if (empty($data['PHONE'])) {
    $arErrors[] = 'Заполните поле "Телефон"';
}

/* данные из формы */
$arFields = $data;

if (empty($arErrors)) {
    CModule::IncludeModule('iblock');
    $el = new CIBlockElement;                   // создаем новый элемент ИБ

    $arLoadProductArray = Array(
        "IBLOCK_ID"      => FEEDBACK_IBLOCK,                  // id нужного инфоблока
        "PROPERTY_VALUES"=> $arFields,                     // массив свойств
        "NAME"           => date("d.m.Y H:i:s"),    // название элемента
        "ACTIVE"         => "Y",                          // активность элемента
    );

    $PRODUCT_ID = $el->Add($arLoadProductArray);   // создаем ИБ с этими полями

    if (!$PRODUCT_ID) {
        $arErrors[] = $el->LAST_ERROR;
    }

    /* отправка письма */
    $fileds = [
        "AUTHOR" => $data["NAME"],
        "AUTHOR_PHONE" => $data["PHONE"],
    ];
    CEvent::Send("FEEDBACK_FORM", SITE_ID, $fileds);     // отправляем поля

    $arResponse = [
        'STATUS' => 'success',
    ];

} else {
    $arResponse = [
        'STATUS' => 'error',
        'ERRORS' => $arErrors,
    ];
}

echo Bitrix\Main\Web\Json::encode($arResponse);
die();
