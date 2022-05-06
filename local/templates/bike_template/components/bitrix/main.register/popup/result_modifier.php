<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();

// сортировка
$sort_fileds = [];
foreach ($arResult["SHOW_FIELDS"] as $FIELD){
    if($FIELD = "NAME")
        $sort_fileds[0] = $FIELD;
    if($FIELD = "PERSONAL_PHONE")
        $sort_fileds[1] = $FIELD;
    if($FIELD = "LOGIN")
        $sort_fileds[2] = $FIELD;
    if($FIELD = "EMAIL")
        $sort_fileds[3] = $FIELD;
    if($FIELD = "PASSWORD")
        $sort_fileds[4] = $FIELD;
    if($FIELD = "CONFIRM_PASSWORD")
        $sort_fileds[5] = $FIELD;
}
$arResult["SHOW_FIELDS"] = $sort_fileds;