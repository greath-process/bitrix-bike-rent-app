<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Personal Area");
?>
<section>
    <div class="b-container">
        <div class="sect-gray">
            <h1 class="other-page h1_lk"><?= $APPLICATION->GetTitle() ?></h1>

            <? $APPLICATION->IncludeComponent(
                "bitrix:menu",
                "personal",
                array(
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
                    "ROOT_MENU_TYPE" => "personal",    // Тип меню для первого уровня
                    "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                ),
                false
            ); ?>

            <? $APPLICATION->IncludeComponent(
                "bitrix:main.profile",
                "personal",
                array(
                    "CHECK_RIGHTS" => "N",    // Проверять права доступа
                    "SEND_INFO" => "N",    // Генерировать почтовое событие
                    "SET_TITLE" => "Y",    // Устанавливать заголовок страницы
                    "USER_PROPERTY" => array(    // Показывать доп. свойства
                        0 => "UF_ADDRESS_DELIVERY",
                    ),
                    "USER_PROPERTY_NAME" => "",    // Название закладки с доп. свойствами
                ),
                false
            ); ?>
            
        </div>
    </div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>