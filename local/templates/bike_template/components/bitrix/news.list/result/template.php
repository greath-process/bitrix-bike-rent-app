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
<section class="b-result">
    <div class="b-container">
        <div class="result sect-gray sect-perehoc">
            <div class="result-parametr">
                <div class="parametrs">
                    <div class="parametrs-item">
                        <div class="parametrs-item__title"><?=GetMessage('BRAND')?></div>
                        <div class="parametrs-item__select">
                            <select name="param__brand" class="b-select chosen-select">
                                <option value="all"><?=GetMessage("ALL")?></option>
                                <? foreach ($arResult["BRAND_LIST"] as $brand): ?>
                                    <option value="<?=$brand?>"><?=$brand?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="parametrs-item">
                        <div class="parametrs-item__title"><?=GetMessage('FRAME_SIZE')?></div>
                        <div class="parametrs-item__select">
                            <select name="param__frame" class="b-select chosen-select">
                                <option value="all"><?=GetMessage("ALL")?></option>
                                <? foreach ($arResult["FRAME_LIST"] as $frame): ?>
                                    <option value="<?=$frame?>"><?=$frame?></option>
                                <? endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="result-rbike">
                <div class="rbike">
                    <? foreach ($arResult["ITEMS"] as $arItem): ?>
                        <?
                        $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                        $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                        $busy = false; // условия "занят"
                        if(!empty($arResult["BUSY"]["ITEMS"]["VALUES"][$arItem["ID"]])){
                            $busy = true;
                        }
                        ?>
                        <div class="rbike-wrap <? if ($busy) echo "rbike-wrap_disable"; ?>"
                             id="<?= $this->GetEditAreaId($arItem['ID']); ?>"
                             data-frame="<?= $arItem["PROPERTIES"]["FRAME"]["VALUE"] ?>"
                             data-brand="<?= $arItem["PROPERTIES"]["BRAND"]["VALUE"] ?>"
                             data-id="<?=$arItem["ID"]?>"
                        >
                            <div class="rbike-item <? if ($busy) echo "rbike-item_busy"; ?>">
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
                                <? if ($busy): ?>
                                    <div class="rbike-busy">
                                        <a class="rbike-busy__date" href="#popup-freedate" data-name="<?=$arItem["NAME"]?>" data-id="<?=$arItem["ID"]?>"><?=GetMessage("SEE_FREE_DATES")?></a>
                                        <a class="rbike-busy__link b-button button_gray"><?=GetMessage("BUSY")?></a>
                                    </div>
                                <? else: ?>
                                    <a class="rbike-item__link b-button button_space" id="btn_choose"
                                       data-id="<?=$arItem["ID"]?>"
                                        <?if($_SESSION["prod_arr"][$arItem["ID"]] == $arItem["ID"])
                                            echo 'style="display: none"'?>
                                    >
                                        <?=GetMessage("CHOOSE")?>
                                    </a>

                                    <a class="rbike-item__link b-button button_fill button_take"
                                       data-id="<?=$arItem["ID"]?>"
                                        <?if($_SESSION["prod_arr"][$arItem["ID"]] != $arItem["ID"])
                                            echo 'style="display: none"'?>
                                    >
                                        <span class="take-yes"><?=GetMessage("CHOOSED")?></span>
                                        <span class="take-no"><?=GetMessage("CANCEL_CHOICE")?></span>
                                    </a>
                                <? endif; ?>
                            </div>
                        </div>
                    <? endforeach; ?>
                </div>
            </div>
            <div class="b-submit b-submit_result">
                <a href="#popup-select_bicycle" id="select_bicycle" style="display: none;" name="modal"></a>
                <input class="b-button b-button_submit button_fill button_big" id="checkout" type="submit" data-href="/checkout/" value="<?=GetMessage("NEXT")?>">
            </div>
        </div>
    </div>
</section>

<!------------------Всплывающее выберите велосипед---------------!-->
<div id="popup-select_bicycle" class="popup-window">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full"><?=GetMessage('NO_SELECT')?></div>
    </div>
</div>
