<?
require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");
$APPLICATION->SetTitle("Contacts");
?><section>
    <div class="b-container">
        <div class="sect-gray">
            <h1 class="other-page"><?= $APPLICATION->ShowTitle() ?></h1>
            <div class="cont-col">
                <div class="cont6-item">
                    <div class="cont-info">
                        <div class="sub-info">
                            <div class="sub-info__text">Phone number</div>
                            <div class="sub-info__value">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/contact_phone.php"
                                    )
                                ); ?>
                            </div>
                        </div>
                        <div class="sub-info">
                            <div class="sub-info__text">E-mail</div>
                            <div class="sub-info__value">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/contact_mail.php"
                                    )
                                ); ?>
                            </div>
                        </div>
                        <div class="sub-info">
                            <div class="sub-info__text">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/contact_title.php"
                                    )
                                ); ?>
                            </div>
                            <div class="sub-info__value">
                                <? $APPLICATION->IncludeComponent(
                                    "bitrix:main.include",
                                    "",
                                    array(
                                        "AREA_FILE_SHOW" => "file",
                                        "AREA_FILE_SUFFIX" => "inc",
                                        "EDIT_TEMPLATE" => "",
                                        "PATH" => "/include/contact_address.php"
                                    )
                                ); ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="cont6-item">
                    <div class="sub-text">Apply now</div>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/feedback_form.php"
                        )
                    ); ?>
                </div>
            </div>
<!--
            <div class="cont-map">
                <div id="map">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:map.yandex.view",
                        ".default",
                        array(
                            "API_KEY" => "dc3f2316-7a8c-478e-93f6-7237518c6e23",
                            "CONTROLS" => array(),
                            "INIT_MAP_TYPE" => "MAP",
                            "MAP_DATA" => "a:5:{s:10:\"yandex_lat\";d:55.75797438976178;s:10:\"yandex_lon\";d:37.55134133300778;s:12:\"yandex_scale\";i:11;s:10:\"PLACEMARKS\";a:1:{i:0;a:3:{s:3:\"LON\";d:37.57537392578123;s:3:\"LAT\";d:55.75270820649988;s:4:\"TEXT\";s:10:\"адрес\";}}s:9:\"POLYLINES\";a:0:{}}",
                            "MAP_HEIGHT" => "600",
                            "MAP_ID" => "",
                            "MAP_WIDTH" => "100%",
                            "OPTIONS" => array(
                                0 => "ENABLE_DBLCLICK_ZOOM",
                                1 => "ENABLE_DRAGGING",
                            ),
                            "COMPONENT_TEMPLATE" => ".default"
                        ),
                        false
                    ); ?>
                </div>
            </div>
-->
        </div>
    </div>
</section>
<? require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/footer.php"); ?>