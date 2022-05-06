<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application;
CModule::IncludeModule("iblock");

unset($_SESSION["prod_arr"]);
if(!empty($_POST["ids"])) {
    $return_str = '';
    $interval = $_POST["interval"];

    $arSelect = array(
        "ID",
        "IBLOCK_ID",
        "NAME",
        "DATE_ACTIVE_FROM",
        "PROPERTY_PRICE_FOR_DAYS",
        "PROPERTY_PRICE_FOR_HOURS"
    );
    $arFilter = array(
        "IBLOCK_ID" => RENT_IBLOCK,
        "ID" => $_POST["ids"]
    );
    $rsItems = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
    while ($Item = $rsItems->Fetch()) {
        $price = $Item["PROPERTY_PRICE_FOR_" . strtoupper($_POST["type"]) . "_VALUE"];

        $return_str .=
            '<div class="lk-line lk-line_text" data-id="' . $Item["ID"] . '">
            <button class="lk-line__remove-button js-remove" title="Удалить велосипед из заказа">
                <svg viewBox="0 0 24 24">
                    <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"></path>
                </svg>
            </button>
            <div class="lk-item lk-item_600">' . $Item["NAME"] . '</div>
            <div class="lk-item lk-item_200 lk-item_cena">' . intval($price) . '</div>
            <div class="lk-item lk-item_200 lk-item_dney">' . $interval . '</div>
            <div class="lk-item lk-item_200 lk-item_itog">' . intval($price) * $interval . ' AED</div>
        </div>';
    }
    echo $return_str;
}


