<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

//if(strlen($_POST["value"]) > 0)
$_SESSION["ORDER_FIELDS"][$_POST["name"]] = $_POST["value"];
