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

<div class="lk-slide">
    <div class="lk-slide_wrap">
        <div class="lk-line lk-line_head lk-line_title lk-line_mobhide">
            <div class="lk-item lk-item_400"><?= GetMessage('ORDER_NUM') ?></div>
            <div class="lk-item lk-item_200"><?= GetMessage('DATE') ?></div>
            <div class="lk-item lk-item_200"><?= GetMessage('VALUE') ?></div>
            <div class="lk-item lk-item_200 lk-item_oplat"><?= GetMessage('PAYMENT') ?></div>
            <div class="lk-item lk-item_200 lk-item_status"><?= GetMessage('STATUS') ?></div>
        </div>
        <div class="lk-table">
            <? foreach ($arResult["ITEMS"] as $arItem) : ?>
                <?
                $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                ?>
                <div class="accord-item" id="<?= $this->GetEditAreaId($arItem['ID']); ?>">
                    <div class="accord-item__title">
                        <div class="lk-item lk-item_400 lk-item_auto lk-item_toggle"><span class="mob-linetitle"><?= GetMessage('ORDER_NUM') ?>: </span> <?= GetMessage('ORDER') ?> № <?= $arItem['ID'] ?></div>
                        <div class="lk-item lk-item_200 lk-item_auto"><span class="mob-linetitle"><?= GetMessage('DATE') ?>: </span><?= explode(' ', $arItem['DATE_CREATE'])[0] ?></div>
                        <div class="lk-item lk-item_200 lk-item_auto lk-item_price">
                            <span class="mob-linetitle"><?= GetMessage('VALUE') ?>: </span>
                            <?= $arItem['PROPERTIES']['PRICE']['VALUE'] ?>
                        </div>
                        <div class="lk-item lk-item_200 lk-item_auto lk-item_oplat">
                            <span class="mob-linetitle"><?= $arItem['PROPERTIES']['PAID']['NAME'] ?>: </span>
                            <?
                            if ($arItem['PROPERTIES']['PAID']['VALUE'] != "Y" || empty($arItem['PROPERTIES']['PAID']['VALUE']))
                                echo "Not paid";
                            else
                                echo "Paid";
                            ?>
                        </div>
                        <div class="lk-item lk-item_200 lk-item_auto lk-item_status">
                            <span class="mob-linetitle"><?= $arItem['PROPERTIES']['STATUS']['NAME'] ?>: </span>
                            <div class="status <?= $arResult["STATUS"][$arItem['PROPERTIES']['STATUS']['VALUE']]["PROPERTY_CLASS_VALUE"]; ?>">
                                <?= $arResult["STATUS"][$arItem['PROPERTIES']['STATUS']['VALUE']]["NAME"]; ?>
                            </div>
                        </div>
                    </div>
                    <div class="accord-item__content">
                        <div class="accord-item__products">
                            <div class="lk-line lk-line_title">
                                <div class="lk-item lk-item_600"><?= GetMessage('ORDER_LIST') ?></div>
                                <div class="lk-item lk-item_200"><?= GetMessage('PRICE') ?></div>
                                <div class="lk-item lk-item_200 lk-item_dney"><?= GetMessage('COUNT') ?>
                                    <?= ($arItem['PROPERTIES']['TYPE_AREND']['VALUE'] == "days") ? ' days' : ' hours'; ?>
                                </div>
                                <div class="lk-item lk-item_200 lk-item_itog"><?= GetMessage('SUM') ?></div>
                            </div>
                            <?
                            $date_start = date_create($arItem['PROPERTIES']['DATE_START']['VALUE']);
                            $date_end = date_create($arItem['PROPERTIES']['DATE_END']['VALUE']);
                            if ($arItem['PROPERTIES']['TYPE_AREND']['VALUE'] == "hours") {
                                $interval = (date_diff($date_start, $date_end)->h) / 2;
                            } else {
                                $interval = date_diff($date_start, $date_end)->d;
                            }
                            ?>
                            <? foreach ($arItem["PROPERTIES"]["ITEMS"]["VALUE"] as $ID) :
                                $price = $arResult["MY_ITEMS"][$ID]["PRICE_FOR_" . strtoupper($arItem['PROPERTIES']['TYPE_AREND']['VALUE'])];
                            ?>
                                <div class="lk-line lk-line_text">
                                    <div class="lk-item lk-item_600"><?= $arResult["MY_ITEMS"][$ID]["NAME"] ?></div>
                                    <div class="lk-item lk-item_200 lk-item_cena"><?= intval($price) ?></div>
                                    <div class="lk-item lk-item_200 lk-item_dney"><?= $interval ?></div>
                                    <div class="lk-item lk-item_200 lk-item_itog"><?= intval($price) * $interval; ?> AED</div>
                                </div>
                            <? endforeach; ?>
                        </div>
                        <div class="accord-item__ship">
                            <div class="lk-line lk-line_itog" style="display: none">
                                <div class="lk-item lk-item_600"></div>
                                <div class="lk-item lk-item_200"></div>
                                <div class="lk-item lk-item_200 lk-item_info"><?= GetMessage('DELIVERY') ?></div>
                                <div class="lk-item lk-item_200 lk-item_status"><?= $arItem['PROPERTIES']['PRICE_DELIVERY']['VALUE'] ?></div>
                            </div>
                            <div class="lk-line lk-line_itog">
                                <div class="lk-item lk-item_600"></div>
                                <div class="lk-item lk-item_200"></div>
                                <div class="lk-item lk-item_200 lk-item_info"><?= GetMessage('TOTAL') ?></div>
                                <div class="lk-item lk-item_200 lk-item_status item-bold"><?= $arItem['PROPERTIES']['PRICE']['VALUE'] ?></div>
                            </div>
                        </div>
                        <div class="accord-item__action">
                            <div class="accord-action">
                                <div class="accord-action_item"><?= GetMessage('TYPE_RENT') ?>: <?= $arResult["LEASE"][$arItem['PROPERTIES']['TYPE_AREND']['VALUE']]['UF_NAME'] ?></div>
                                <div class="accord-action_item"> <?= GetMessage('RENT_PERIOD') ?>: <?= $arItem['PROPERTIES']['DATE_START']['VALUE'] ?> – <?= $arItem['PROPERTIES']['DATE_END']['VALUE'] ?> </div>
                                <div class="accord-action_item"><?= GetMessage('PAYMENT_METHOD') ?>: <?= $arResult["PAYMENT"][$arItem['PROPERTIES']['PAYMENT_SYSTEM']['VALUE']]['UF_NAME'] ?></div>
                                <div class="accord-action_item"><?= GetMessage('DELIVERY_TYPE') ?>: <?= $arResult["DELIVERY"][$arItem['PROPERTIES']['DELIVERY']['VALUE']]['UF_NAME'] ?></div>
                                <? if (!empty($arItem['PROPERTIES']['ADDRESS_DELIVERY']['VALUE'])) : ?>
                                    <div class="accord-action_item"><?=GetMessage('DELIVERY_ADDRESS')?>: <?= $arItem['PROPERTIES']['ADDRESS_DELIVERY']['VALUE'] ?></div>
                                <? endif; ?>
                                <? if (!empty($arItem['PROPERTIES']['ADDRESS_RETURN']['VALUE'])) : ?>
                                    <div class="accord-action_item"><?=GetMessage('RETURN_ADDRESS')?>: <?= $arItem['PROPERTIES']['ADDRESS_RETURN']['VALUE'] ?></div>
                                <? endif; ?>
                            </div>
                            <div class="accord-action">
                                <div class="accord-action_button">
                                    <div class="button_action">
                                        <a href="#popup-cancel" class="b-button button_space button_big b-button_action" name="modal" id="cancel" data-id="<?= $arItem["ID"] ?>">
                                            <?= GetMessage('CANCEL_ORDER') ?>
                                        </a>
                                    </div>
                                    <div class="button_action">
                                        <a href="extend_lease/?ORDER_ID=<?= $arItem["ID"] ?>" class="b-button button_fill button_big b-button_action">
                                            <?= GetMessage('RENEW') ?>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <? endforeach; ?>
        </div>
    </div>
</div>