<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application;

unset($_SESSION["prod_arr"]);
$_SESSION["data_start"] = $_POST["data_start"];
$_SESSION["data_end"] = $_POST["data_end"];
