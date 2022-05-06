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

<section class="b-ftype">
    <div class="b-container">
        <div class="sect-gray sect-perehoc">
            <div class="lk-slide">
                <div class="lk-slide_wrap">
                    <div class="lk-line lk-line_head lk-line_title lk-line_mobhide">
                        <div class="lk-item lk-item_400">Номер заказа</div>
                        <div class="lk-item lk-item_200">Фактическая дата возврата</div>
                        <div class="lk-item lk-item_200">Стоимость</div>
                        <div class="lk-item lk-item_200 lk-item_oplat">Оплата</div>
                        <div class="lk-item lk-item_200 lk-item_status">Статус</div>
                    </div>
                    <div class="lk-table">
                        <? foreach ($arResult["ITEMS"] as $arItem): ?>
                        <div class="accord-item" data-id="<?=$arItem['ID']?>">
                            <div class="accord-item__title">
                                <div class="lk-item lk-item_400 lk-item_auto lk-item_toggle"><span class="mob-linetitle">Номер заказа: </span>Заказ № <?=$arItem['ID']?></div>
                                <div class="lk-item lk-item_200 lk-item_auto"><span class="mob-linetitle">Фактическая дата возврата: </span><?=$arItem['PROPERTIES']['DATE_RETURN']['VALUE']?></div>
                                <div class="lk-item lk-item_200 lk-item_auto lk-item_price"><span class="mob-linetitle">Стоимость: </span> <?=$arItem['PROPERTIES']['PRICE']['VALUE']?></div>
                                <div class="lk-item lk-item_200 lk-item_auto lk-item_oplat"><span class="mob-linetitle">Оплата: </span>
                                    <div class="lk-item__select js-status-select"
                                         data-status="<?if($arItem['PROPERTIES']['PAID']['VALUE'] == "Y") echo "paid"; else echo "unpaid";?>">
                                        <select class="chosen-select" name="PAID">
                                                <option value="unpaid"
                                                >Не оплачен</option>
                                                <option value="paid"
                                                    <?if($arItem['PROPERTIES']['PAID']['VALUE'] == "Y") echo "selected";?>
                                                >Оплачен</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="lk-item lk-item_200 lk-item_auto lk-item_status"><span class="mob-linetitle">Статус: </span>
                                    <div class="lk-item__select js-status-select" data-status="<?=$arResult["STATUS"][$arItem['PROPERTIES']['STATUS']['VALUE']]["ADMIN_CLASS"]?>">
                                        <select class="chosen-select" name="STATUS">
                                            <?foreach ($arResult["STATUS"] as $status):?>
                                                <option value="<?=$status["ADMIN_CLASS"]?>"
                                                    <?if($arItem['PROPERTIES']['STATUS']['VALUE'] == $status["ID"]) echo "selected";?>
                                                >
                                                    <?=$status["NAME"]?>
                                                </option>
                                            <?endforeach;?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="accord-item__content">
                                <div class="accord-item__products">
                                    <div class="lk-line lk-line_title">
                                        <div class="lk-item lk-item_600">Велосипеды</div>
                                        <div class="lk-item lk-item_200">Цена</div>
                                        <div class="lk-item lk-item_200 lk-item_dney">Кол-во
                                            <?=($arItem['PROPERTIES']['TYPE_AREND']['VALUE'] == "days") ? ' дней' : ' часов';?></div>
                                        <div class="lk-item lk-item_200 lk-item_itog">Сумма</div>
                                    </div>
                                    <?
                                    $date_start = date_create($arItem['PROPERTIES']['DATE_START']['VALUE']);
                                    $date_end = date_create($arItem['PROPERTIES']['DATE_END']['VALUE']);
                                    if($arItem['PROPERTIES']['TYPE_AREND']['VALUE'] == "hours"){
                                        $interval = (date_diff($date_start, $date_end)->h)/2;
                                    }
                                    else {
                                        $interval = date_diff($date_start, $date_end)->d;
                                    }
                                    ?>
                                    <? foreach ($arItem["PROPERTIES"]["ITEMS"]["VALUE"] as $ID):
                                        $price = $arResult["MY_ITEMS"][$ID]["PRICE_FOR_".strtoupper($arItem['PROPERTIES']['TYPE_AREND']['VALUE'])];
                                        ?>
                                        <div class="lk-line lk-line_text">
                                            <div class="lk-item lk-item_600"><?=$arResult["MY_ITEMS"][$ID]["NAME"]?></div>
                                            <div class="lk-item lk-item_200 lk-item_cena"><?=intval($price)?></div>
                                            <div class="lk-item lk-item_200 lk-item_dney"><?=$interval?></div>
                                            <div class="lk-item lk-item_200 lk-item_itog"><?=intval($price)*$interval;?> AED</div>
                                        </div>
                                    <?endforeach;?>
                                </div>
                                <div class="accord-item__ship">
                                    <div class="lk-line lk-line_itog" style="display:none;">
                                        <div class="lk-item lk-item_600"> </div>
                                        <div class="lk-item lk-item_200"></div>
                                        <div class="lk-item lk-item_200 lk-item_info">Доставка</div>
                                        <div class="lk-item lk-item_200 lk-item_status"><?=$arItem['PROPERTIES']['PRICE_DELIVERY']['VALUE']?></div>
                                    </div>
                                    <div class="lk-line lk-line_itog">
                                        <div class="lk-item lk-item_600"></div>
                                        <div class="lk-item lk-item_200"></div>
                                        <div class="lk-item lk-item_200 lk-item_info">Итого</div>
                                        <div class="lk-item lk-item_200 lk-item_status item-bold"><?=$arItem['PROPERTIES']['PRICE']['VALUE']?></div>
                                    </div>
                                </div>
                                <!-- edit area -->
                                <div class="accord-item__action accord-item__action_admin js-edit-area">
                                    <div class="accord-action">
                                        <div class="lk-line lk-line_title">
                                            <div class="lk-item lk-item_600">Информация об аренде</div>
                                        </div>
                                        <div class="accord-action_item">Тип аренды: <?=$arResult["LEASE"][$arItem['PROPERTIES']['TYPE_AREND']['VALUE']]['UF_NAME']?></div>
                                        <div class="accord-action_item">Период аренды: <?=$arItem['PROPERTIES']['DATE_START']['VALUE']?> – <?=$arItem['PROPERTIES']['DATE_END']['VALUE']?></div>
                                        <div class="accord-action_item">Тип оплаты: <?=$arResult["PAYMENT"][$arItem['PROPERTIES']['PAYMENT_SYSTEM']['VALUE']]['UF_NAME']?></div>
                                        <div class="accord-action_item">Тип доставки: <?=$arResult["DELIVERY"][$arItem['PROPERTIES']['DELIVERY']['VALUE']]['UF_NAME']?></div>
                                        <div class="accord-action_item">Адрес доставки: <?=$arItem['PROPERTIES']['ADDRESS_DELIVERY']['VALUE']?></div>
                                        <div class="accord-action_item">Адрес возврата: <?=$arItem['PROPERTIES']['ADDRESS_RETURN']['VALUE']?></div>
                                    </div>
                                    <div class="accord-action">
                                        <div class="lk-line lk-line_title">
                                            <div class="lk-item lk-item_600">Контакты пользователя</div>
                                        </div>
                                        <div class="accord-action_item"><?=$arItem['PROPERTIES']['USER_NAME']['VALUE']?></div>
                                        <div class="accord-action_item"><?=$arItem['PROPERTIES']['PHONE']['VALUE']?></div>
                                        <div class="accord-action_item">
                                            <?$rsUser = CUser::GetByID($arItem['PROPERTIES']['USER']['VALUE']);
                                            $arUser = $rsUser->Fetch();
                                            echo $arUser['EMAIL'];?>
                                        </div>
                                    </div>
                                    <div class="accord-action">
                                        <div class="lk-line lk-line_title">
                                            <div class="lk-item lk-item_600">Комментарий (для администратора)</div>
                                        </div>
                                        <div class="accord-action_item"><?=$arItem['PROPERTIES']['ADMIN_COMMENT']['VALUE']?></div>
                                    </div>
                                    <div class="accord-action accord-action_button">
                                        <div class="button_action">
                                            <a href="#popup-cancel" class="b-button button_space button_big b-button_action"
                                               name="modal" id="cancel" data-id="<?=$arItem["ID"]?>" style="padding-top: 10px;"
                                            >
                                                Отменить заказ
                                            </a>
                                        </div>
                                        <div class="button_action">
                                            <a class="b-button button_fill button_big b-button_action js-order-edit" id="admin_order_edit" data-edit="<?=$arItem["ID"]?>">Редактировать</a>
                                        </div>
                                        <div class="button_action">
                                            <a class="b-button button_big button_space button_big b-button_action" onclick="window.open('/personal/admin/checkue.php?orderId=<?=$arItem['ID']?>', '_blank');">Чек</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?endforeach;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>