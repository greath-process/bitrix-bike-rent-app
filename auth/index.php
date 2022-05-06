<?if (isset($_GET["register"]) && $_GET["register"] == "yes"):?>
    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");?>
        <?$APPLICATION->IncludeComponent(
            "bitrix:main.register",
            "popup",
            Array(
                "AUTH" => "Y",
                "REQUIRED_FIELDS" => array("EMAIL", "NAME", "PERSONAL_PHONE"),
                "SET_TITLE" => "Y",
                "SHOW_FIELDS" => array("EMAIL", "NAME", "PERSONAL_PHONE"),
                "SUCCESS_PAGE" => "",
                "USER_PROPERTY" => array(),
                "USER_PROPERTY_NAME" => "",
                "USE_BACKURL" => "Y"
            )
        );?>
    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
else:
    define("NEED_AUTH", true);
    require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");

    $userName = $USER->GetFullName();
    if (!$userName)
        $userName = $USER->GetLogin();
    ?>
    <script>
        <?if ($userName):?>
        BX.localStorage.set("eshop_user_name", "<?=CUtil::JSEscape($userName)?>", 604800);
        <?else:?>
        BX.localStorage.remove("eshop_user_name");
        <?endif?>

        <?if (isset($_REQUEST["backurl"]) && $_REQUEST["backurl"] <> '' && preg_match('#^/\w#', $_REQUEST["backurl"])):?>
        document.location.href = "<?=CUtil::JSEscape($_REQUEST["backurl"])?>";
        <?endif?>
    </script>

    <?
    $APPLICATION->SetTitle("Авторизация");
    ?>
    <p>You are registered and logged in successfully.</p>

    <p><a href="<?=SITE_DIR?>">Back to mainpage</a></p>

    <?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
<?endif;?>
