<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

use Bitrix\Main\Page\Asset;
use \Bitrix\Main\Loader;
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;

global $USER;

$assets = Asset::getInstance();

?>
<!DOCTYPE html>
<html lang="<?=LANGUAGE_ID?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title><?$APPLICATION->ShowTitle()?></title>
    <?$APPLICATION->ShowHead();?>
    <?
    // CSS
    $assets->addCss(SITE_TEMPLATE_PATH . "/css/datepicker.css");
    $assets->addCss(SITE_TEMPLATE_PATH . "/css/chosen.min.css");

    $assets->addCss(SITE_TEMPLATE_PATH . "/css/slick.css");
    $assets->addCss(SITE_TEMPLATE_PATH . "/css/slick-theme.css");
    $assets->addCss(SITE_TEMPLATE_PATH . "/css/jquery.smoothdivscroll-1.3.css");
    $assets->addCss(SITE_TEMPLATE_PATH . "/css/daterangepicker.min.css");

    $assets->addCss(SITE_TEMPLATE_PATH . "/css/style.css");
    $assets->addCss(SITE_TEMPLATE_PATH . "/css/media.css");

    // JS
    $assets->addString('<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js" type="text/javascript"></script>');

//    $assets->addJs("https://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js");
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/chosen.jquery.min.js");
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/slick.min.js");

    $assets->addJs(SITE_TEMPLATE_PATH . "/js/jquery-ui-1.8.23.custom.min.js");
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/jquery.mousewheel.min.js");
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/jquery.kinetic.min.js");
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/jquery.smoothdivscroll-1.3-min.js");

    $assets->addString('<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.16.0/moment.min.js" type="text/javascript"></script>');
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/moment-timezone-with-data-10-year-range.js");

    $assets->addJs(SITE_TEMPLATE_PATH . "/js/jquery.daterangepicker.min.js");

    $assets->addJs(SITE_TEMPLATE_PATH . "/js/jquery.inputmask.min.js");
    $assets->addJs(SITE_TEMPLATE_PATH . "/js/custom.js");


    // STRING
    $assets->addString('<link rel="shortcut icon" href="/favicon.ico" type="image/x-icon">');
    ?>

</head>
<body class="b-page">
    <header class="b-head">
        <?$manager_group_id = array(1,7,8);
        if(array_intersect($manager_group_id, $USER->GetUserGroupArray())):?>
            <a class="user-link user-lk" style="text-align: center;margin-top: 20px; display: block; font-weight: bolder;" href="/personal/admin/">
                <span class="user-link__text">Кабинет оператора</span>
            </a>
        <?endif;?>
        <div class="b-container b-head__wrap">
            <div class="b-head__logo">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    Array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/logo.php"
                    )
                );?>
            </div>
            <div class="b-head__menu">
                <? $APPLICATION->IncludeComponent("bitrix:menu", "top_menu", array(
                    "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                    "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                    "DELAY" => "N",    // Откладывать выполнение шаблона меню
                    "MAX_LEVEL" => "1",    // Уровень вложенности меню
                    "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                        0 => "",
                    ),
                    "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                    "MENU_CACHE_TYPE" => "A",    // Тип кеширования
                    "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                    "ROOT_MENU_TYPE" => "top",    // Тип меню для первого уровня
                    "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                ),
                    false
                ); ?>
                <div class="b-cont">
                    <div class="b-user">
                        <div class="b-user__ico">
                            <svg class="b-user__img" width="22" height="22" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg"><circle cx="11" cy="4.75" r="3.75" stroke-width="2"/><path d="M1.25 19.6875C1.25 15.718 4.46795 12.5 8.4375 12.5H13.5625C17.532 12.5 20.75 15.718 20.75 19.6875V19.6875C20.75 19.8601 20.6101 20 20.4375 20H1.5625C1.38991 20 1.25 19.8601 1.25 19.6875V19.6875Z" stroke-width="2"/></svg>
                        </div>
                        <div class="b-user__down">
                            <?if(!$USER->IsAuthorized()):?>
                            <a class="user-link user-lk" name="modal" href="#popup-lk">
                                <span class="user-link__text">Log in</span>
                            </a>
                            <?else:?>
                            <a class="user-link user-lk" href="/personal/">
                                <span class="user-link__text">Personal Area</span>
                            </a>
                            <a class="user-link user-exit" href="<?= $APPLICATION->GetCurPageParam("logout=yes&".bitrix_sessid_get(), array(
                                "login",
                                "logout",
                                "register",
                                "forgot_password",
                                "change_password"));?>"
                            >
                                <span class="user-link__text">Log out</span>
                            </a>
                            <?endif;?>
                        </div>
                    </div>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        Array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/feedback_btn.php"
                        )
                    );?>
                </div>
            </div>
            <div class="b-head__right">
                <div class="b-time">
                    <div id="b-time" class="b-time__text">12:00</div>
                </div>
                <div class="mobile-menu">
                    <div class="mobile-menu__icon"></div>
                </div>
            </div>
        </div>
    </header>
<?//if($USER->IsAdmin()):?>
<?$APPLICATION->ShowPanel()?>
<?//endif?>
