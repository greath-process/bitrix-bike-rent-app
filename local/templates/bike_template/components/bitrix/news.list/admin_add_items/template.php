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
<div class="result-rbike">
    <div class="rbike">
        <? foreach ($arResult["ITEMS"] as $arItem): ?>
            <?
            if(!empty($arResult["BUSY"]["ITEMS"]["VALUES"][$arItem["ID"]])){ // условия "занят"
                continue;
            }
            ?>
            <div class="rbike-wrap"
                 data-frame="<?= $arItem["PROPERTIES"]["FRAME"]["VALUE"] ?>"
                 data-brand="<?= $arItem["PROPERTIES"]["BRAND"]["VALUE"] ?>"
                 data-section="<?=$arItem["IBLOCK_SECTION_ID"]?>"
                 data-id="<?=$arItem["ID"]?>"
            >
                <div class="rbike-item">
                    <div class="rbike-item__head">
                        <div class="rbike-item__rama"><?= $arItem["PROPERTIES"]["FRAME"]["VALUE"] ?></div>
                        <div class="rbike-item__brand"><?= $arItem["PROPERTIES"]["BRAND"]["VALUE"] ?></div>
                    </div>
                    <div class="rbike-item__img">
                        <img class="rbike-img" src="<?= $arItem["PREVIEW_PICTURE"]["SRC"] ?>"
                             alt="<?= $arItem["PREVIEW_PICTURE"]["ALT"] ?>"
                             title="<?= $arItem["PREVIEW_PICTURE"]["TITLE"] ?>"/>
                    </div>
                    <div class="rbike-item__descr"><?= $arItem["NAME"] ?></div>
                    <? if ($arParams["TYPE_PERIOD"] == "days"): ?>
                        <div class="price"
                             id="days"><?=$arItem["PROPERTIES"]["PRICE_FOR_DAYS"]["VALUE"]?><?=GetMessage("OF")?><?=GetMessage("DAY")?>
                        </div>
                    <? else: ?>
                        <div class="price"
                             id="hours"><?=$arItem["PROPERTIES"]["PRICE_FOR_HOURS"]["VALUE"]?><?=GetMessage("OF")?><?=GetMessage("HOURS")?>
                        </div>
                    <? endif; ?>

                    <a class="rbike-item__link b-button button_space" id="btn_choose"
                       data-id="<?=$arItem["ID"]?>"
                    >
                        <?=GetMessage("CHOOSE")?>
                    </a>

                    <a class="rbike-item__link b-button button_fill button_take"
                       data-id="<?=$arItem["ID"]?>"
                       style="display: none"
                    >
                        <span class="take-yes"><?=GetMessage("CHOOSED")?></span>
                        <span class="take-no"><?=GetMessage("CANCEL_CHOICE")?></span>
                    </a>
                </div>
            </div>
        <? endforeach; ?>
    </div>
</div>
