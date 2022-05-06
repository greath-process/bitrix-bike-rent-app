<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();


$iblock_id = $arParams["IBLOCK_ID"];

/* РАЗДЕЛЫ ИНФОБЛОКА */
$arFilter = array('IBLOCK_ID' => $iblock_id);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
//    "IBLOCK_TYPE_ID",
    "CODE",
    "SECTION_ID",
    'NAME',
    'PICTURE',
    "DESCRIPTION",
    "UF_*"
    );
$rsSections = CIBlockSection::GetList(array('LEFT_MARGIN' => 'ASC'), $arFilter, false, $arSelect);
while ($arSection = $rsSections->Fetch()) {
    $arResult["SECTIONS"][] = $arSection;
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
    $arResult["LEASE"][] = $el;
}
/* Доставка */
$entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC"),
    'filter' => array('UF_ACTIVE' => '1')
));
while ($el = $rsData->fetch()) {
    $arResult["DELIVERY"][] = $el;
}
