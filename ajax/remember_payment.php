<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");

if(intval($_POST["id"]) > 0)
    $_SESSION["payment"]= $_POST["id"];
