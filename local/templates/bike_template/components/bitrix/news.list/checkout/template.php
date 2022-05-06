<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
$this->setFrameMode(true);
?>
<section>
    <div class="b-container">
        <div class="sect-gray">
            <h1 class="other-page other-page_order"><?= $APPLICATION->ShowTitle() ?></h1>
            <div class="order-info">
                <div class="sub-info order-info__item">
                    <div class="sub-info__text"><?= GetMessage('RENT_TYPE') ?></div>
                    <div class="sub-info__value">
                        <? foreach ($arResult["LEASE"] as $lease) {
                            if ($_SESSION["param__arend"] == $lease["UF_XML_ID"])
                                echo $lease["UF_NAME"];
                        }
                        ?>
                    </div>
                </div>
                <div class="sub-info order-info__item order-info_order1">
                    <div class="sub-info__text"><?= GetMessage('TIMESTAMP_START') ?></div>
                    <div class="sub-info__value"><?= $_SESSION["data_start"] ?></div>
                </div>
                <div class="sub-info order-info__item order-info_order2">
                    <div class="sub-info__text"><?= GetMessage('TIMESTAMP_END') ?></div>
                    <div class="sub-info__value"><?= $_SESSION["data_end"] ?></div>
                </div>
                <div class="sub-info order-info__item">
                    <div class="sub-info__text"><?= GetMessage('DELIVERY') ?></div>
                    <div class="sub-info__value">
                        <? foreach ($arResult["DELIVERY"] as $delivery) {
                            if ($_SESSION["type_delivery"] == $delivery["UF_VALUE"])
                                echo $delivery["UF_NAME"];
                        }
                        ?>
                    </div>
                </div>
            </div>

            <div class="order-table order-table_check">
                <div class="order-slide">
                    <div class="order-line order-line_title">
                        <div class="sub-text order-item order-item_img"></div>
                        <div class="sub-text order-item order-item_name"><?= GetMessage('BIKE_NAME') ?></div>
                        <div class="sub-text order-item order-item_shlem"><?= GetMessage('ADD_HELMET') ?></div>
                        <div class="sub-text order-item order-item_fonarik"><?= GetMessage('ADD_LIGHT') ?></div>
                        <div class="sub-text order-item order-item_zamok"><?= GetMessage('ADD_LOCK') ?></div>
                        <div class="sub-text order-item order-item_price text-right"><?= GetMessage('VALUE') ?></div>
                    </div>
                    <? $total = 0;
                    $date_start = date_create_from_format('d.m.Y H:i', $_SESSION["data_start"]);
                    $date_end = date_create_from_format('d.m.Y H:i', $_SESSION["data_end"]);
                    if ($_SESSION["param__arend"] == "hours") {
                        $interval = (date_diff($date_start, $date_end)->h) / 2;
                    } else {
                        $interval = date_diff($date_start, $date_end)->d;
                    } ?>
                    <? foreach ($arResult["ITEMS"] as $arItem) : ?>
                        <div class="order-line" data-id="<?= $arItem['ID'] ?>">
                            <div class="order-item order-item_img">
                                <div class="table-img">
                                    <img src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>" alt="demo_order">
                                </div>
                            </div>
                            <div class="order-item order-item_name"><?= $arItem["NAME"] ?></div>
                            <div class="order-item order-item_shlem">
                                <input type="checkbox" class="checkbox" name="helmet" <? if (!empty($_SESSION['additional'][$arItem['ID']]['helmet'])) echo "checked" ?> id="shlem-<?= $arItem['ID'] ?>" data-id="<?= $arItem['ID'] ?>">
                                <label class="label-check" for="shlem-<?= $arItem['ID'] ?>">
                                    <span class="accept32">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="10" fill="currentcolor" />
                                            <path d="M16 20L18.9995 23L23.9995 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </label>
                            </div>
                            <div class="order-item order-item_fonarik">
                                <input type="checkbox" class="checkbox" name="lighter" <? if (!empty($_SESSION['additional'][$arItem['ID']]['lighter'])) echo "checked" ?> id="fonarik-<?= $arItem['ID'] ?>" data-id="<?= $arItem['ID'] ?>">
                                <label class="label-check" for="fonarik-<?= $arItem['ID'] ?>">
                                    <span class="accept32">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="10" fill="currentcolor" />
                                            <path d="M16 20L18.9995 23L23.9995 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </label>
                            </div>
                            <div class="order-item order-item_zamok">
                                <input type="checkbox" class="checkbox" name="lock" <? if (!empty($_SESSION['additional'][$arItem['ID']]['lock'])) echo "checked" ?> id="zamok-<?= $arItem['ID'] ?>" data-id="<?= $arItem['ID'] ?>">
                                <label class="label-check" for="zamok-<?= $arItem['ID'] ?>">
                                    <span class="accept32">
                                        <svg width="40" height="40" viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <rect width="40" height="40" rx="10" fill="currentcolor" />
                                            <path d="M16 20L18.9995 23L23.9995 18" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>
                                </label>
                            </div>
                            <div class="order-item order-item_price text-right">
                                <div class="price price_order"><?= $arItem["PROPERTIES"]["PRICE_FOR_" . strtoupper($arParams["TYPE_PERIOD"])]["VALUE"] ?></div>
                            </div>
                        </div>
                    <? $total += $interval * intval($arItem["PROPERTIES"]["PRICE_FOR_" . strtoupper($arParams["TYPE_PERIOD"])]["VALUE"]);
                    endforeach; ?>
                </div>
            </div>
            <div class="order-total">
                <div class="order-ship">
                    <div class="order-ship__line" style="display: none;">
                        <div class="sub-text"><?= GetMessage('DELIVERY') ?></div>
                        <div class="order-ship__value text-right">
                            <div class="price price_ship">0 AED</div>
                        </div>
                    </div>
                    <div class="order-ship__line">
                        <div class="sub-text"><?= GetMessage('TOTAL') ?></div>
                        <div class="order-ship__value text-right">
                            <div class="price" id="TOTAL"><?= $total ?> AED</div>
                        </div>
                    </div>
                </div>
                <div class="order-total__back">
                    <a href="/?back=Y" class="button-back"><?=GetMessage('BACK_TO_SEARCH')?></a>
                </div>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="b-container">
        <div class="sect-gray sect-perehoc">
            <form class="form checkout-form" id="order_form">
                <div class="block-col">
                    <div class="col6-item">
                        <div class="sub-info__text"><?=GetMessage('CONTACTS')?></div>
                        <div class="checkout-osndan">
                            <div class="form-line form-line_osndan">
                                <input type="text" class="input" name="USER_NAME" required placeholder="<?=GetMessage('NAME_HINT')?>*" value="<? if ($USER->IsAuthorized())
                                                                                                                            echo $USER->GetFirstName();
                                                                                                                        else
                                                                                                                            echo $_SESSION["ORDER_FIELDS"]["USER_NAME"];
                                                                                                                        ?>" />
                            </div>
                            <div class="form-line form-line_osndan">
                                <input type="text" min="8" class="input masc-phone" name="PHONE" required placeholder="<?=GetMessage('PHONE_HINT')?>*" value="<? if ($USER->IsAuthorized())
                                                                                                                                                    echo $arResult['PERSONAL_PHONE'];
                                                                                                                                                else
                                                                                                                                                    echo $_SESSION["ORDER_FIELDS"]["PHONE"];
                                                                                                                                                ?>" />
                            </div>
                            <div class="form-line form-line_osndan">
                                <input type="text" class="input" name="EMAIL" required placeholder="<?=GetMessage('EMAIL_HINT')?>*" value="<? if ($USER->IsAuthorized())
                                                                                                                        echo $USER->GetEmail();
                                                                                                                    else
                                                                                                                        echo $_SESSION["ORDER_FIELDS"]["EMAIL"];
                                                                                                                    ?>" />
                            </div>
                        </div>
                        <? if ($_SESSION["type_delivery"] != "pickup") : ?>
                            <div class="sub-info__text checkout-form_otstup"><?=GetMessage('DELIVERY_TITLE')?></div>
                            <div class="form-line form-line_otstup">
                                <input type="text" name="ADDRESS_DELIVERY" required class="input" placeholder="<?=GetMessage('ADDRESS_HINT')?>*" value="<? if ($USER->IsAuthorized())
                                                                                                                                    echo $arResult['UF_ADDRESS_DELIVERY'];
                                                                                                                                else
                                                                                                                                    echo $_SESSION["ORDER_FIELDS"]["UF_ADDRESS_DELIVERY"];
                                                                                                                                ?>" />
                            </div>
                        <? endif; ?>

                        <div class="sub-info__text"><?=GetMessage('PAY_TITLE')?></div>
                        <div class="form-line form-line_radio">
                            <? $first = true;
                            foreach ($arResult["PAYMENT"] as $pay) : ?>
                                <div class="form-radio form-radio_checkout">
                                    <input type="radio" <? if ($first == true && empty($_SESSION["payment"]))
                                                            echo "checked";
                                                        elseif (!empty($_SESSION["payment"]) && $_SESSION["payment"] == $pay["ID"])
                                                            echo "checked";
                                                        ?> name="PAYMENT_SYSTEM" class="radio" id="radio-<?= $pay["ID"] ?>" data-id="<?= $pay["ID"] ?>" value="<?= $pay["ID"] ?>">
                                    <label class="label-radio label-radio_checkout" for="radio-<?= $pay["ID"] ?>">
                                        <span class="radiokrug"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <circle cx="16" cy="16" r="15.5" stroke="#DDE3EB" />
                                                <circle cx="15.9999" cy="15.9997" r="10.6667" fill="currentcolor" />
                                            </svg></span>
                                        <?= $pay["UF_NAME"] ?>
                                        <? if (!empty($pay["UF_DESCRIPTION"])) : ?>
                                            <div class="radio-question">
                                                <a class="question but-qvad" tabindex="0"></a>
                                                <div class="hint hint_radio"><?= $pay["UF_DESCRIPTION"] ?></div>
                                            </div>
                                        <? endif; ?>
                                    </label>
                                </div>
                            <? $first = false;
                            endforeach; ?>
                        </div>
                    </div>
                    <div class="col6-item">
                        <div class="sub-info__text"><?=GetMessage('RETURN_DATE')?></div>
                        <div class="block-data">
                            <div class="data-item">
                                <div class="form-line">
                                    <? $finish_date = strstr($_SESSION["data_end"], " ", true);
                                    $finish_date = explode('.', $finish_date);
                                    ?>
                                    <input type="date" class="input" name="DATE_RETURN" value="<?= $finish_date[2] . '-' . $finish_date[1] . '-' . $finish_date[0] ?>" />
                                </div>
                            </div>
                            <div class="data-item">
                                <div class="form-line">
                                    <input type="time" class="input" name="TIME_RETURN" value="00:00" />
                                </div>
                            </div>
                        </div>
                        <div class="form-line">
                            <input type="text" class="input" name="ADDRESS_RETURN" placeholder="<?= GetMessage('ADDRESS_RETURN')?>" />
                        </div>
                        <div class="message message_checkout">
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/return_bicycle.php"
                                )
                            ); ?>
                            <? $APPLICATION->IncludeComponent(
                                "bitrix:main.include",
                                "",
                                array(
                                    "AREA_FILE_SHOW" => "file",
                                    "AREA_FILE_SUFFIX" => "inc",
                                    "EDIT_TEMPLATE" => "",
                                    "PATH" => "/include/return_address.php"
                                )
                            ); ?>
                        </div>
                    </div>
                </div>

                <div class="order-link order-link_broni center">
                    <input type="hidden" name="min_price" value="<?= intval($arParams['MINIMUM_PRICE']) ?>">
                    <a href="#popup-minimum_price" id="minimum_price" style="display: none;" name="modal"></a>
                    <button type="submit" class="b-button button_fill button_big b-button_check" id="make_order"><?=GetMessage('RESERVE')?></button>
                </div>
            </form>
        </div>
    </div>
</section>

<!------------------Всплывающее минимальная цена заказа---------------!-->
<div id="popup-minimum_price" class="popup-window">
    <a href="#" class="popup-close">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg>
    </a>
    <div class="popup-content">
        <div class="popup-title popup-title_full">
            <? printf(GetMessage('MIN_SUMM_REQUIRE'),intval($arParams['MINIMUM_PRICE']) )?>
        </div>
    </div>
</div>