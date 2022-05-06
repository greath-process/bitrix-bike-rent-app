<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if ($_POST["action"] == "add")
    $_SESSION["additional"][$_POST["id"]][$_POST['name']] = $_POST["name"];
elseif ($_POST["action"] == "delete")
    unset($_SESSION["additional"][$_POST["id"]][$_POST['name']]);
