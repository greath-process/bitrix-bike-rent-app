<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application;

$_SESSION["admin_filter"] = $_POST;

//filter
$Filter = [];
// Дата и время начала аренды
if(!empty($_POST["param__date_start"]) && empty($_POST["param__date_end"])) {
    $temp_data = explode(' ',$_POST["param__date_start"])[0];
    $Filter[">=PROPERTY_DATE_START"] = date("Y-m-d H:i:s", strtotime($temp_data));
    $Filter["<=PROPERTY_DATE_START"] = date("Y-m-d H:i:s", strtotime($temp_data." 23:59:59"));
}
// Дата и время конца аренды
elseif(!empty($_POST["param__date_end"]) && empty($_POST["param__date_start"])) {
    $temp_data = explode(' ',$_POST["param__date_end"])[0];
    $Filter[">=PROPERTY_DATE_END"] = date("Y-m-d H:i:s", strtotime($temp_data));
    $Filter["<=PROPERTY_DATE_END"] = date("Y-m-d H:i:s", strtotime($temp_data." 23:59:59"));

}
// интервал дат
elseif(!empty($_POST["param__date_start"]) && !empty($_POST["param__date_end"])){
    $Filter[">=PROPERTY_DATE_START"] = date("Y-m-d H:i:s", strtotime($_POST["param__date_start"]));
    $Filter["<=PROPERTY_DATE_END"] = date("Y-m-d H:i:s", strtotime($_POST["param__date_end"]));
}
// Фактическая дата возврата
if(!empty($_POST["param__date_return"])) {
    $Filter[">=PROPERTY_DATE_RETURN"] = date("Y-m-d H:i:s", strtotime($_POST["param__date_return"]));
    $Filter["<=PROPERTY_DATE_RETURN"] = date("Y-m-d H:i:s", strtotime($_POST["param__date_return"]." 23:59:59"));
}
// Статус заказа
if($_POST["param__status"] != "all")
    $Filter["=PROPERTY_STATUS"] = $_POST["param__status"];
// Тип аренды
if($_POST["param__arend"] != "all")
    $Filter["=PROPERTY_TYPE_AREND"] = $_POST["param__arend"];
// Доставка
if($_POST["param__delivery"] != "all")
    $Filter["=PROPERTY_DELIVERY"] = $_POST["param__delivery"];
// Тип оплаты
if($_POST["param__payment"] != "all")
    $Filter["=PROPERTY_PAYMENT_SYSTEM"] = $_POST["param__payment"];
// Статус оплаты
if($_POST["param__paid"] != "all")
    $Filter["=PROPERTY_PAID_VALUE"] = $_POST["param__paid"];

$GLOBALS['adminFilter'] = $Filter;

$APPLICATION->IncludeComponent(
	"bitrix:news.list",
	"admin_result",
	Array(
		"ACTIVE_DATE_FORMAT" => "d.m.Y",
		"ADD_SECTIONS_CHAIN" => "N",
		"AJAX_MODE" => "N",
		"AJAX_OPTION_ADDITIONAL" => "",
		"AJAX_OPTION_HISTORY" => "N",
		"AJAX_OPTION_JUMP" => "N",
		"AJAX_OPTION_STYLE" => "Y",
		"CACHE_FILTER" => "N",
		"CACHE_GROUPS" => "Y",
		"CACHE_TIME" => "36000000",
		"CACHE_TYPE" => "N",
		"CHECK_DATES" => "Y",
		"COMPONENT_TEMPLATE" => "orders",
		"DETAIL_URL" => "",
		"DISPLAY_BOTTOM_PAGER" => "N",
		"DISPLAY_DATE" => "Y",
		"DISPLAY_NAME" => "Y",
		"DISPLAY_PICTURE" => "Y",
		"DISPLAY_PREVIEW_TEXT" => "Y",
		"DISPLAY_TOP_PAGER" => "N",
		"FIELD_CODE" => array(0=>"ID",1=>"NAME",2=>"DATE_CREATE",3=>"",),
		"FILTER_NAME" => "adminFilter",
		"HIDE_LINK_WHEN_NO_DETAIL" => "N",
		"IBLOCK_ID" => ORDER_IBLOCK,
		"IBLOCK_TYPE" => "catalogs",
		"INCLUDE_IBLOCK_INTO_CHAIN" => "N",
		"INCLUDE_SUBSECTIONS" => "Y",
		"MESSAGE_404" => "",
		"MINIMUM_PRICE" => "",
		"NEWS_COUNT" => "999",
		"PAGER_BASE_LINK_ENABLE" => "N",
		"PAGER_DESC_NUMBERING" => "N",
		"PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
		"PAGER_SHOW_ALL" => "N",
		"PAGER_SHOW_ALWAYS" => "N",
		"PAGER_TEMPLATE" => ".default",
		"PAGER_TITLE" => "Новости",
		"PARENT_SECTION" => "",
		"PARENT_SECTION_CODE" => "",
		"PREVIEW_TRUNCATE_LEN" => "",
		"PROPERTY_CODE" => array(0=>"",1=>"DATE_START",2=>"DATE_END",3=>"DATE_RETURN",4=>"ADDRESS_RETURN",5=>"ADDRESS_DELIVERY",6=>"USER",7=>"USER_NAME",8=>"PHONE",9=>"TYPE_AREND",10=>"PAYMENT_SYSTEM",11=>"DELIVERY",12=>"PRICE",13=>"PRICE_DELIVERY",14=>"PAID",15=>"",),
		"SET_BROWSER_TITLE" => "N",
		"SET_LAST_MODIFIED" => "N",
		"SET_META_DESCRIPTION" => "N",
		"SET_META_KEYWORDS" => "N",
		"SET_STATUS_404" => "N",
		"SET_TITLE" => "N",
		"SHOW_404" => "N",
		"SORT_BY1" => "ACTIVE_FROM",
		"SORT_BY2" => "SORT",
		"SORT_ORDER1" => "DESC",
		"SORT_ORDER2" => "ASC",
		"STRICT_SECTION_CHECK" => "N"
	)
);
