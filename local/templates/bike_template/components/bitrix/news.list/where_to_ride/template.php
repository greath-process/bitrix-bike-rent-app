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
        <div class="sect-gray ride-page">
            <h1 class="other-page"><? $APPLICATION->ShowTitle(false) ?></h1>
            <div class="items-list-wrapper slide-wrap">
                <? foreach ($arResult["ITEMS"] as $arItem) : ?>
                    <?
                    $this->AddEditAction($arItem['ID'], $arItem['EDIT_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_EDIT"));
                    $this->AddDeleteAction($arItem['ID'], $arItem['DELETE_LINK'], CIBlock::GetArrayByID($arItem["IBLOCK_ID"], "ELEMENT_DELETE"), array("CONFIRM" => GetMessage('CT_BNL_ELEMENT_DELETE_CONFIRM')));
                    ?>
                    <div class="ride-page__wrapper">
                        <div class="ride-page__inner">
                            <div class="desc">
                                <div class="subtitle subtitle_ride"><?= $arItem["NAME"] ?></div>
                                <div class="two-thirds">
                                    <? if ($arItem["PREVIEW_TEXT"] <> '') : ?>
                                        <? echo $arItem["PREVIEW_TEXT"]; ?>
                                    <? else : ?>
                                        <? echo $arItem["DETAIL_TEXT"]; ?>
                                    <? endif ?>
                                </div>
                            </div>
                            <? if (!empty($arItem["PROPERTIES"]["PHOTOS"]["VALUE"])) : ?>
                                <div class="gallery">
                                    <? foreach ($arItem["PROPERTIES"]["PHOTOS"]["VALUE"] as $photo) : ?>
                                        <div class="gallery__item"><img class="radius" src="<?= CFile::GetPath($photo) ?>"></div>
                                    <? endforeach; ?>
                                </div>
                            <? endif; ?>
                        </div>
                    </div>
                <? endforeach; ?>
            </div>
        </div>
    </div>
</section>