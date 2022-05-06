<?
define("NEED_AUTH", true);
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Order history");
?>
    <section>
        <div class="b-container">
            <div class="sect-gray cabinet">
                <h1 class="other-page h1_lk"><?= $APPLICATION->GetTitle() ?></h1>

                <? $APPLICATION->IncludeComponent("bitrix:menu", "personal", array(
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
                <?
                $GLOBALS['orderFilter'] = array('=PROPERTY_USER' => $USER->GetID(), '=PROPERTY_STATUS' => array(CANCEL_STATUS, COMPLETE_STATUS));
                ?>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:news.list",
                    "orders_history",
                    array(
                        "ACTIVE_DATE_FORMAT" => "d.m.Y",
                        "ADD_SECTIONS_CHAIN" => "N",
                        "AJAX_MODE" => "N",
                        "AJAX_OPTION_ADDITIONAL" => "",
                        "AJAX_OPTION_HISTORY" => "N",
                        "AJAX_OPTION_JUMP" => "N",
                        "AJAX_OPTION_STYLE" => "Y",
                        "CACHE_FILTER" => "N",
                        "CACHE_GROUPS" => "Y",
                        "CACHE_TIME" => "36000000",
                        "CACHE_TYPE" => "A",
                        "CHECK_DATES" => "Y",
                        "DETAIL_URL" => "",
                        "DISPLAY_BOTTOM_PAGER" => "N",
                        "DISPLAY_DATE" => "Y",
                        "DISPLAY_NAME" => "Y",
                        "DISPLAY_PICTURE" => "Y",
                        "DISPLAY_PREVIEW_TEXT" => "Y",
                        "DISPLAY_TOP_PAGER" => "N",
                        "FIELD_CODE" => array(
                            0 => "ID",
                            1 => "NAME",
                            2 => "DATE_CREATE",
                            3 => "",
                        ),
                        "FILTER_NAME" => "orderFilter",
                        "HIDE_LINK_WHEN_NO_DETAIL" => "N",
                        "IBLOCK_ID" => ORDER_IBLOCK,
                        "IBLOCK_TYPE" => "catalogs",
                        "INCLUDE_IBLOCK_INTO_CHAIN" => "N",
                        "INCLUDE_SUBSECTIONS" => "Y",
                        "MESSAGE_404" => "",
                        "MINIMUM_PRICE" => "",
                        "NEWS_COUNT" => "999",
                        "PAGER_BASE_LINK_ENABLE" => "N",
                        "PAGER_DESC_NUMBERING" => "N",
                        "PAGER_DESC_NUMBERING_CACHE_TIME" => "36000",
                        "PAGER_SHOW_ALL" => "N",
                        "PAGER_SHOW_ALWAYS" => "N",
                        "PAGER_TEMPLATE" => ".default",
                        "PAGER_TITLE" => "Новости",
                        "PARENT_SECTION" => "",
                        "PARENT_SECTION_CODE" => "",
                        "PREVIEW_TRUNCATE_LEN" => "",
                        "PROPERTY_CODE" => array(
                            0 => "DATE_START",
                            1 => "DATE_END",
                            2 => "DATE_RETURN",
                            3 => "ADDRESS_RETURN",
                            4 => "ADDRESS_DELIVERY",
                            5 => "USER",
                            6 => "USER_NAME",
                            7 => "PHONE",
                            8 => "TYPE_AREND",
                            9 => "PAYMENT_SYSTEM",
                            10 => "DELIVERY",
                            11 => "PRICE",
                            12 => "PRICE_DELIVERY",
                            13 => "PAID",
                            14 => "",
                        ),
                        "SET_BROWSER_TITLE" => "N",
                        "SET_LAST_MODIFIED" => "N",
                        "SET_META_DESCRIPTION" => "N",
                        "SET_META_KEYWORDS" => "N",
                        "SET_STATUS_404" => "N",
                        "SET_TITLE" => "N",
                        "SHOW_404" => "N",
                        "SORT_BY1" => "ACTIVE_FROM",
                        "SORT_BY2" => "SORT",
                        "SORT_ORDER1" => "DESC",
                        "SORT_ORDER2" => "ASC",
                        "STRICT_SECTION_CHECK" => "N",
                        "COMPONENT_TEMPLATE" => "orders_history"
                    ),
                    false
                ); ?>

            </div>
        </div>
    </section>

<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>