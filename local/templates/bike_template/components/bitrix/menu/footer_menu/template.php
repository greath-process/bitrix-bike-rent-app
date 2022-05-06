<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="b-menu b-menu_fmenu">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
	echo "<pre style='display: none'>".print_r($arItem,1)."</pre>";
?>
	<?if($arItem["SELECTED"]):?>
		<a href="<?=$arItem["LINK"]?>" class="b-link b-link_fmenu f-link"><?=$arItem["TEXT"]?></a>
	<?else:?>
		<a href="<?=$arItem["LINK"]?>" <?if(!empty($arItem["PARAMS"]["ATTR"])) echo $arItem["PARAMS"]["ATTR"];?> class="b-link b-link_fmenu f-link"><?=$arItem["TEXT"]?></a>
	<?endif?>
	
<?endforeach?>
</div>
<?endif?>