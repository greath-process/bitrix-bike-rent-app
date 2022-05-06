<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application;

CModule::IncludeModule("iblock");

$arSelect = Array("ID", "IBLOCK_ID", "DATE_ACTIVE_FROM", "PROPERTY_DATE_START", "PROPERTY_DATE_END");
$arFilter = Array(
    "IBLOCK_ID"=>ORDER_IBLOCK,
    "PROPERTY_ITEMS" => $_POST["id"],
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
?>
<?$APPLICATION->IncludeComponent(
	"bitrix:main.feedback",
	"popup_freeDates",
	Array(
		"DISABLED_DATES" => $DATES, // масив недоступных дат
		"ITEM_NAME" => $_POST["name"],
		"EMAIL_TO" => "",
		"EVENT_MESSAGE_ID" => "",
		"OK_TEXT" => "",
		"REQUIRED_FIELDS" => "",
		"USE_CAPTCHA" => "N"
	)
);?>
<?php
die();
