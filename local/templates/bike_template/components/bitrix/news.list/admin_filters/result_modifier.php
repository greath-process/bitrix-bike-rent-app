<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('iblock');

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
}

CModule::IncludeModule('highloadblock');
/* Аренда */
$entity_data_class = GetEntityDataClass(HLB_LEASE_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC"),
//    'filter' => array('UF_ACTIVE' => '1')
));
while ($el = $rsData->fetch()) {
    $arResult["LEASE"][] = $el;
}
/* Доставка */
$entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC"),
//    'filter' => array('UF_ACTIVE' => '1')
));
while ($el = $rsData->fetch()) {
    $arResult["DELIVERY"][] = $el;
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