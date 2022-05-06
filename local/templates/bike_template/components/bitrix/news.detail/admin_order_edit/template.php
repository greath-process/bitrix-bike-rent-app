<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
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
    <div class="accord-item__title">
        <?$arProp = $arResult["PROPERTIES"]?>
        <div class="lk-item lk-item_400 lk-item_auto lk-item_toggle"><span class="mob-linetitle">Номер заказа: </span>Заказ № <?=$arResult["ID"]?></div>
        <div class="lk-item lk-item_200 lk-item_auto"><span class="mob-linetitle">Фактическая дата возврата: </span><?=$arProp["DATE_RETURN"]["VALUE"]?></div>
        <div class="lk-item lk-item_200 lk-item_auto lk-item_price"><span class="mob-linetitle">Стоимость: </span><?=$arProp["PRICE"]["VALUE"]?></div>
        <div class="lk-item lk-item_200 lk-item_auto lk-item_oplat">
            <span class="mob-linetitle">Оплата: </span>
            <div class="lk-item__select js-status-select"
                 data-status="<?if($arProp['PAID']['VALUE'] == "Y") echo "paid"; else echo "unpaid";?>">
                <select class="chosen-select" name="PAID">
                    <option value="unpaid" data-value=""
                    >Не оплачен</option>
                    <option value="paid" data-value="Y"
                        <?if($arProp['PAID']['VALUE'] == "Y") echo "selected";?>
                    >Оплачен</option>
                </select>
            </div>
        </div>
        <div class="lk-item lk-item_200 lk-item_auto lk-item_status">
            <span class="mob-linetitle">Статус: </span>
            <div class="lk-item__select js-status-select" data-status="<?=$arResult["STATUS"][$arProp['STATUS']['VALUE']]["ADMIN_CLASS"]?>">
                <select class="chosen-select" name="STATUS">
                    <?foreach ($arResult["STATUS"] as $status):?>
                        <option value="<?=$status["ADMIN_CLASS"]?>" data-value="<?=$status["ID"]?>"
                            <?if($arProp['STATUS']['VALUE'] == $status["ID"]) echo "selected";?>
                        >
                            <?=$status["NAME"]?>
                        </option>
                    <?endforeach;?>
                </select>
            </div>
        </div>
    </div>
    <div class="accord-item__content js-item-container" style="display: block;">
        <!-- product-->
        <div class="accord-item__products">
            <div class="lk-line lk-line_title">
                <div class="lk-item lk-item_600">Велосипеды</div>
                <div class="lk-item lk-item_200">Цена</div>
                <div class="lk-item lk-item_200 lk-item_dney">Кол-во<?=($arProp['TYPE_AREND']['VALUE'] == "days") ? ' дней' : ' часов';?></div>
                <div class="lk-item lk-item_200 lk-item_itog">Сумма</div>
            </div>
            <?
            $date_start = date_create($arProp['DATE_START']['VALUE']);
            $date_end = date_create($arProp['DATE_END']['VALUE']);
            if($arProp['TYPE_AREND']['VALUE'] == "hours"){
                $interval = (date_diff($date_start, $date_end)->h)/2;
            }
            else {
                $interval = date_diff($date_start, $date_end)->d;
            }
            ?>
            <?foreach ($arProp["ITEMS"]["VALUE"] as $ID):
                $price = $arResult["MY_ITEMS"][$ID]["PRICE_FOR_".strtoupper($arProp['TYPE_AREND']['VALUE'])];?>
                <div class="lk-line lk-line_text" data-id="<?=$ID?>">
                    <button class="lk-line__remove-button js-remove" title="Удалить велосипед из заказа">
                        <svg viewBox="0 0 24 24">
                            <path fill="currentColor" d="M19,4H15.5L14.5,3H9.5L8.5,4H5V6H19M6,19A2,2 0 0,0 8,21H16A2,2 0 0,0 18,19V7H6V19Z"></path>
                        </svg>
                    </button>
                    <div class="lk-item lk-item_600"><?=$arResult["MY_ITEMS"][$ID]["NAME"]?></div>
                    <div class="lk-item lk-item_200 lk-item_cena"><?=intval($price)?></div>
                    <div class="lk-item lk-item_200 lk-item_dney"><?=$interval?></div>
                    <div class="lk-item lk-item_200 lk-item_itog"><?=intval($price)*$interval;?> AED</div>
                </div>
            <?endforeach;?>

            <div class="accord-item__products-add" data-type="<?=$arProp['TYPE_AREND']['VALUE']?>">
                <div class="admin-search-result">
                    <div class="result-parametr">
                        <div class="parametrs">
                            <div class="parametrs-item">
                                <div class="parametrs-item__title">Тип велосипеда</div>
                                <div class="parametrs-item__select">
                                    <select class="b-select chosen-select" name="param__section">
                                        <option value="all">Все</option>
                                        <?foreach ($arResult["SECTIONS"] as $arSection):?>
                                            <option value="<?=$arSection["ID"]?>"><?=$arSection["NAME"]?></option>
                                        <?endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="parametrs-item">
                                <div class="parametrs-item__title">Бренд</div>
                                <div class="parametrs-item__select">
                                    <select class="b-select chosen-select" name="param__brand">
                                        <option value="all">Все</option>
                                        <?foreach ($arResult["BRAND_LIST"] as $brand):?>
                                            <option value="<?=$brand?>"><?=$brand?></option>
                                        <?endforeach;?>
                                    </select>
                                </div>
                            </div>
                            <div class="parametrs-item">
                                <div class="parametrs-item__title">Размер рамы</div>
                                <div class="parametrs-item__select">
                                    <select class="b-select chosen-select" name="param__frame">
                                        <option value="all">Все</option>
                                        <? foreach ($arResult["FRAME_LIST"] as $frame): ?>
                                            <option value="<?=htmlspecialchars($frame);?>"><?=$frame?></option>
                                        <? endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="js-search-result"></div>
                </div>
                <div class="accord-action_button">
                    <a class="b-button button_fill button_big button_normal js-search-button"
                       data-type="<?=$arProp['TYPE_AREND']['VALUE']?>"
                       data-start="<?=$arProp['DATE_START']['VALUE']?>"
                       data-end="<?=$arProp['DATE_END']['VALUE']?>"
                    >Добавить велосипед</a>
                    <a class="b-button button_fill button_big button_normal js-search-close" data-interval="<?=$interval?>">Сохранить</a>
                </div>
            </div>
        </div>
        <!-- edit area-->
        <div class="accord-item__action accord-item__action_admin">
            <div class="accord-action">
                <div class="lk-line lk-line_title">
                    <div class="lk-item lk-item_600">Информация об аренде</div>
                </div>
                <div class="accord-action_item">Тип аренды: <?=$arResult["LEASE"][$arProp['TYPE_AREND']['VALUE']]['UF_NAME']?></div>
                <div class="accord-action_item">Период аренды: <?=$arProp['DATE_START']['VALUE']?> – <?=$arProp['DATE_END']['VALUE']?></div>
                <div class="accord-action_item parametrs-item">
                    <div class="parametrs-item__title">Тип оплаты</div>
                    <div class="parametrs-item__select">
                        <select class="b-select chosen-select" name="PAYMENT_SYSTEM">
                            <?foreach ($arResult["PAYMENT"] as $pay):?>
                                <option value="<?=$pay["UF_XML_ID"]?>"
                                <?if($pay["UF_XML_ID"] == $arProp['PAYMENT_SYSTEM']['VALUE']) echo "selected";?>
                                ><?=$pay['UF_NAME']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="accord-action_item parametrs-item">
                    <div class="parametrs-item__title">Тип доставки</div>
                    <div class="parametrs-item__select">
                        <select class="b-select chosen-select" name="DELIVERY">
                            <?foreach ($arResult["DELIVERY"] as $delivery):?>
                                <option value="<?=$delivery["UF_XML_ID"]?>"
                                    <?if($delivery["UF_XML_ID"] == $arProp['DELIVERY']['VALUE']) echo "selected";?>
                                ><?=$delivery['UF_NAME']?></option>
                            <?endforeach;?>
                        </select>
                    </div>
                </div>
                <div class="accord-action_item parametrs-item">
                    <div class="parametrs-item__title">Адрес доставки</div>
                    <div class="parametrs-item__select">
                        <input class="input" name="ADDRESS_DELIVERY" type="text" value="<?=$arProp["ADDRESS_DELIVERY"]["VALUE"]?>">
                    </div>
                </div>
                <div class="accord-action_item parametrs-item">
                    <div class="parametrs-item__title">Адрес возврата</div>
                    <div class="parametrs-item__select">
                        <input class="input" name="ADDRESS_RETURN" type="text" value="<?=$arProp["ADDRESS_RETURN"]["VALUE"]?>">
                    </div>
                </div>
            </div>
            <div class="accord-action">
                <div class="lk-line lk-line_title">
                    <div class="lk-item lk-item_600">Контакты пользователя</div>
                </div>
                <div class="accord-action_item"><?=$arProp["USER_NAME"]["VALUE"]?></div>
                <div class="accord-action_item"><?=$arProp['PHONE']['VALUE']?></div>
                <div class="accord-action_item">
                    <?$rsUser = CUser::GetByID($arProp['USER']['VALUE']);
                    $arUser = $rsUser->Fetch();
                    echo $arUser['EMAIL'];?>
                </div>
            </div>
            <div class="accord-action">
                <div class="lk-line lk-line_title">
                    <div class="lk-item lk-item_600">Комментарий (для администратора)</div>
                </div>
                <div class="accord-action_item">
                    <input class="input" type="text" name="ADMIN_COMMENT" value="<?=$arProp['ADMIN_COMMENT']['VALUE']?>">
                </div>
            </div>
            <div class="accord-action accord-action_button">
                <div class="button_action">
                    <a class="b-button button_space button_big b-button_action"
                       data-id="<?=$arResult["ID"]?>"
                       id="btn_cancel_order_edit"
                    >
                        Отменить
                    </a>
                </div>
                <div class="button_action">
                    <a class="b-button button_fill button_big b-button_action"
                       data-id="<?=$arResult["ID"]?>"
                       id="btn_save_order_edit"
                    >
                        Сохранить
                    </a>
                </div>
                <!--
                <div class="button_action">
                    <a class="b-button button_big button_space button_big b-button_action" onclick="window.open('/personal/admin/checkue.php?orderId=<?=$arResult['ID']?>', '_blank');">Чек</a>
                </div>
                -->
            </div>
        </div>
    </div>