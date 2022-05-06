<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<?if (!empty($arResult)):?>
<div class="lk-burger">
    <div class="burger-arrow"><b><svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M4.99944 8L9.99944 13L14.9994 8" stroke="#297FFF" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path></svg></b></div>
    <div class="lk-menu lk-tab3">
<?
foreach($arResult as $arItem):
	if($arParams["MAX_LEVEL"] == 1 && $arItem["DEPTH_LEVEL"] > 1) 
		continue;
?>
	<?if($arItem["SELECTED"]):?>
        <div class="lk-menu__tab"><a class="lk-menu__link lk-menu_active" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
	<?else:?>
        <div class="lk-menu__tab"><a class="lk-menu__link" href="<?=$arItem["LINK"]?>"><?=$arItem["TEXT"]?></a></div>
	<?endif?>
	
<?endforeach?>
    </div>
</div>
<?endif?>