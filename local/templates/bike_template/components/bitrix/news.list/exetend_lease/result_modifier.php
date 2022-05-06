<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
CModule::IncludeModule('iblock');

$arResult["ITEM"] = $arResult["ITEMS"][0];

$arSelect = Array("ID", "IBLOCK_ID", "DATE_ACTIVE_FROM", "PROPERTY_DATE_START", "PROPERTY_DATE_END");
$arFilter = Array(
    "IBLOCK_ID"=>ORDER_IBLOCK,
    "PROPERTY_ITEMS" => $arResult["ITEM"]["PROPERTIES"]["ITEMS"]["VALUE"],
    ">=PROPERTY_DATE_START" => date("Y-m-d"),
    "!PROPERTY_STATUS" => array(CANCEL_STATUS, COMPLETE_STATUS),
);
$DATES = [];
$rsItems = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($Item = $rsItems->GetNextElement()) {
    $arProps = $Item->GetProperties();

    $begin = new DateTime( $arProps['DATE_START']['VALUE'] );
    $end = new DateTime( $arProps['DATE_END']['VALUE'] );
    $end = $end->modify( '+1 day' );

    $interval = new DateInterval('P1D');
    $daterange = new DatePeriod($begin, $interval ,$end);

    foreach($daterange as $date){
        $DATES[] = $date->format("d.m.Y");
    }
}
$DATES = array_unique($DATES);
$arResult["DISABLED_DATES"] = $DATES;

/* Товары */
$arFilter = array('IBLOCK_ID' => RENT_IBLOCK,'ID'=>$arResult["ITEM"]["PROPERTIES"]["ITEMS"]["VALUE"]);
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
//$entity_data_class = GetEntityDataClass(HLB_LEASE_ID);
//$rsData = $entity_data_class::getList(array(
//    'select' => array('*'),
//    "order" => array("UF_SORT" => "ASC"),
//    'filter' => array('UF_ACTIVE' => '1')
//));
//while ($el = $rsData->fetch()) {
//    $arResult["LEASE"][$el["UF_XML_ID"]] = $el;
//}

/* Доставка */
//$entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
//$rsData = $entity_data_class::getList(array(
//    'select' => array('*'),
//    "order" => array("UF_SORT" => "ASC"),
//    'filter' => array('UF_ACTIVE' => '1')
//));
//while ($el = $rsData->fetch()) {
//    $arResult["DELIVERY"][$el["UF_XML_ID"]] = $el;
//}

/* Оплата */
$entity_data_class = GetEntityDataClass(HLB_PAYMENT_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    "order" => array("UF_SORT" => "ASC")
));
while ($el = $rsData->fetch()) {
    $arResult["PAYMENT"][$el["UF_XML_ID"]] = $el;
}


