<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Loader,
    Bitrix\Main\Application;

$_SESSION["prod_arr"][$_POST["id"]] = $_POST["id"];

