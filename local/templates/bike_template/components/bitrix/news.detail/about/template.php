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
<section>
    <div class="b-container">
        <div class="sect-gray about-info">
            <h1 class="other-page"><?=$arResult["NAME"]?></h1>
            <div class="block-col">
                <div class="col6-item">
                    <?if($arResult["DETAIL_TEXT"] <> ''):?>
                        <?echo $arResult["DETAIL_TEXT"];?>
                    <?else:?>
                        <?echo $arResult["PREVIEW_TEXT"];?>
                    <?endif?>
                </div>
                <div class="col6-item">
                    <?if(!empty($arResult["PREVIEW_PICTURE"])):?>
                        <img class="radius"
                             src="<?=$arResult["PREVIEW_PICTURE"]["SRC"]?>"
                             alt="<?=$arResult["PREVIEW_PICTURE"]["ALT"]?>"
                             title="<?=$arResult["PREVIEW_PICTURE"]["TITLE"]?>"
                        >
                    <?else:?>
                        <img class="radius"
                             src="<?=$arResult["DETAIL_PICTURE"]["SRC"]?>"
                             alt="<?=$arResult["DETAIL_PICTURE"]["ALT"]?>"
                             title="<?=$arResult["DETAIL_PICTURE"]["TITLE"]?>"
                        >
                    <?endif;?>
                </div>
            </div>
        </div>
    </div>
</section>