<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

/* Свойства Brand & Frame */
foreach ($arResult["ITEMS"] as $arItems){
    $arResult["BRAND_LIST"][$arItems["PROPERTIES"]["BRAND"]["VALUE"]] = $arItems["PROPERTIES"]["BRAND"]["VALUE"];
    $arResult["FRAME_LIST"][$arItems["PROPERTIES"]["FRAME"]["VALUE"]] = $arItems["PROPERTIES"]["FRAME"]["VALUE"];
}
sort($arResult["BRAND_LIST"]);
sort($arResult["FRAME_LIST"],SORT_NUMERIC);

/* если интервали пересекаются - "Занят" */
$start = date_create_from_format('d.m.Y H:i', $arParams["PARAMS_DATE_START"]);
$end = date_create_from_format('d.m.Y H:i',$arParams["PARAMS_DATE_END"]);
$start = date_format($start,"Y-m-d");
$end = date_format($end,"Y-m-d")." 23:59:59";

CModule::IncludeModule("iblock");

$arSelect = Array("ID", "IBLOCK_ID", "DATE_ACTIVE_FROM", "PROPERTY_DATE_START", "PROPERTY_DATE_END");
$arFilter = Array(
    "IBLOCK_ID"=>ORDER_IBLOCK,
    array(
        'LOGIC' => 'OR',
        array(
            ">=PROPERTY_DATE_START" => $start,
            "<=PROPERTY_DATE_START" => $end,
            "!PROPERTY_STATUS" => array(CANCEL_STATUS, COMPLETE_STATUS),
        ),
        array(
            ">=PROPERTY_DATE_END" => $start,
            "<=PROPERTY_DATE_END" => $end,
            "!PROPERTY_STATUS" => array(CANCEL_STATUS, COMPLETE_STATUS),
        ),
    ),
);
$rsItems = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
while($Item = $rsItems->GetNextElement()) {
    $arFields = $Item->GetFields();
    $arProps = $Item->GetProperties();
    $arResult["BUSY"][$arFields["ID"]] = $arFields;
    foreach ($arProps["ITEMS"]['VALUE'] as $itemId){
        $arResult["BUSY"]["ITEMS"]["VALUES"][$itemId] = $itemId;
    }
}
