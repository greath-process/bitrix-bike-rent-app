<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('iblock');
/* РАЗДЕЛЫ ИНФОБЛОКА */
$arFilter = array('IBLOCK_ID' => $arParams["IBLOCK_ID"]);
$arSelect = array(
    "ID",
    "IBLOCK_ID",
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

/* Оплата */
$entity_data_class = GetEntityDataClass(HLB_PAYMENT_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC")
));
while ($el = $rsData->fetch()) {
    $arResult["PAYMENT"][] = $el;
}

global $USER;
if($USER->IsAuthorized()) {
    $rsUser = CUser::GetByID($USER->GetID());
    $arUser = $rsUser->Fetch();
    $arResult['PERSONAL_PHONE'] = $arUser['PERSONAL_PHONE'];
    $arResult['UF_ADDRESS_DELIVERY'] = $arUser['UF_ADDRESS_DELIVERY'];
}