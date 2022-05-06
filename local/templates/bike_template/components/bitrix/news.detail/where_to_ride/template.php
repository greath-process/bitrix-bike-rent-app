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
            <h1 class="other-page"><?=$APPLICATION->GetTitle()?></h1>
            <div class="two-thirds">
                <? if ($arResult["PREVIEW_TEXT"]) : ?>
                    <? echo $arResult["PREVIEW_TEXT"]; ?>
                <? else : ?>
                    <? echo $arResult["DETAIL_TEXT"]; ?>
                <? endif ?>
            </div>
            <? if (!empty($arResult["PROPERTIES"]["PHOTOS"]["VALUE"])) : ?>
                <div class="gal-col">
                    <? foreach ($arResult["PROPERTIES"]["PHOTOS"]["VALUE"] as $photo) : ?>
                        <div class="gal4-item"><img class="radius" src="<?= CFile::GetPath($photo) ?>"></div>
                    <? endforeach; ?>
                </div>
            <? endif; ?>
        </div>
    </div>
</section>