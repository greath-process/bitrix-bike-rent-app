<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="b-menu b-menu_top">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
		<a href="<?=$arItem["LINK"]?>" class="b-link b-link_menu b-link_active"><?=$arItem["TEXT"]?></a>
	<?else:?>
		<a href="<?=$arItem["LINK"]?>" class="b-link b-link_menu"><?=$arItem["TEXT"]?></a>
	<?endif?>
<?endforeach?>
    </div>
<?endif?>