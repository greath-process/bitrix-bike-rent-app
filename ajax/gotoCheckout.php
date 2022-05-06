<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application;

$_SESSION["param__arend"] = $_POST["param__arend"];
$_SESSION["type_delivery"] = $_POST["type_delivery"];
$_SESSION["data_start"] = $_POST["data_start"];
$_SESSION["data_end"] = $_POST["data_end"];

$sections = $_POST["sections"];
unset($_SESSION["sections"]);
if(!empty($sections)){
    foreach ($sections as $section){
        $_SESSION["sections"][$section] = $section;
    }
}

if(!empty($_SESSION["prod_arr"]))
    echo json_encode(true);
else
    echo json_encode(false);
