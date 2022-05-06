<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application,
    Bitrix\Main;
CModule::IncludeModule('iblock');

$orderId = intval($_POST["id"]);
CIBlockElement::SetPropertyValuesEx($orderId, false, array("STATUS" => CANCEL_STATUS));

$res = CIBlockElement::GetByID($orderId);
if($ar_res = $res->Fetch())
    $orderDate = $ar_res['DATE_CREATE'];

$propFilter = array(
    ">ID" => 1,
    "CODE"=> "USER"
);
$propsDbres = CIBlockElement::GetProperty(ORDER_IBLOCK, $orderId, "sort", "asc", $propFilter);
while ($ob = $propsDbres->GetNext()) {
    if($ob["CODE"] == "USER")
        $userID = $ob['VALUE'];
}

/* user */
$rsUser = CUser::GetByID($userID);
$arUser = $rsUser->Fetch();

$arFields = array(
    'ORDER_ID' => $orderId,
    'ORDER_DATE' => $orderDate,
    'EMAIL' => $arUser['EMAIL'],
);

CEvent::Send("ORDER_CANCEL", SITE_ID, $arFields); // отправляем поля




