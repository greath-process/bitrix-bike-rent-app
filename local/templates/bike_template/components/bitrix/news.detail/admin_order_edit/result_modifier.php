<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('iblock');

/* РАЗДЕЛЫ ИНФОБЛОКА */
$arFilter = array('IBLOCK_ID' => RENT_IBLOCK);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "SECTION_ID",
    'NAME',
);
$rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter, false, $arSelect);
while ($arSection = $rsSections->Fetch()) {
    $arResult["SECTIONS"][] = $arSection;
}
/* список брендов и рам*/
$arFilter = array('IBLOCK_ID' => RENT_IBLOCK,"ACTIVE"=> "Y");
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "CODE",
    'NAME',
    "PROPERTY_BRAND",
    "PROPERTY_FRAME"
);
$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while ($arItems = $rsElements->Fetch()) {
    $arResult["BRAND_LIST"][$arItems["PROPERTY_BRAND_VALUE"]] = $arItems["PROPERTY_BRAND_VALUE"];
    $arResult["FRAME_LIST"][$arItems["PROPERTY_FRAME_VALUE"]] = $arItems["PROPERTY_FRAME_VALUE"];
}
sort($arResult["BRAND_LIST"]);
sort($arResult["FRAME_LIST"],SORT_NUMERIC);

/* Статусы */
$arFilter = array('IBLOCK_ID' => STATUS_IBLOCK,"ACTIVE"=> "Y");
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    "CODE",
    'NAME',
    "PROPERTY_CLASS",
    "PROPERTY_ADMIN_CLASS"
);
$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while ($status = $rsElements->Fetch()) {
    $arResult["STATUS"][$status["ID"]] = $status;
    $arResult["STATUS"][$status["ID"]]["ADMIN_CLASS"] = $status["PROPERTY_ADMIN_CLASS_VALUE"];
}

/* Товары */
$arrItemID = [];
foreach ($arResult["PROPERTIES"]["ITEMS"]["VALUE"] as $ID)
    $arrItemID[$ID] = $ID;

$arFilter = array('IBLOCK_ID' => RENT_IBLOCK,'ID'=>$arrItemID);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
    'NAME',
    "PROPERTY_PRICE_FOR_DAYS",
    "PROPERTY_PRICE_FOR_HOURS"
);
$rsElements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
while ($item = $rsElements->Fetch()) {
    $arResult["MY_ITEMS"][$item["ID"]] = $item;
    $arResult["MY_ITEMS"][$item["ID"]]["PRICE_FOR_DAYS"] = $item["PROPERTY_PRICE_FOR_DAYS_VALUE"];
    $arResult["MY_ITEMS"][$item["ID"]]["PRICE_FOR_HOURS"] = $item["PROPERTY_PRICE_FOR_HOURS_VALUE"];
}

CModule::IncludeModule('highloadblock');

/* Аренда */
$entity_data_class = GetEntityDataClass(HLB_LEASE_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC"),
    'filter' => array('UF_ACTIVE' => '1')
));
while ($el = $rsData->fetch()) {
    $arResult["LEASE"][$el["UF_XML_ID"]] = $el;
}
/* Доставка */
$entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC"),
//    'filter' => array('UF_ACTIVE' => '1')
));
while ($el = $rsData->fetch()) {
    $arResult["DELIVERY"][$el["UF_XML_ID"]] = $el;
}

/* Оплата */
$entity_data_class = GetEntityDataClass(HLB_PAYMENT_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC")
));
while ($el = $rsData->fetch()) {
    $arResult["PAYMENT"][$el["UF_XML_ID"]] = $el;
}


