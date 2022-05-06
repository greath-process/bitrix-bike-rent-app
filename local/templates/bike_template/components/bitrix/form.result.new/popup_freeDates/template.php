<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
?>
<div id="popup-freedate" class="popup-window">
    <input type="hidden" name="disabledDates" value="<?=implode(",", array_values($arParams["DISABLED_DATES"]))?>">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg"><g clip-path="url(#clip0)"><path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></g></svg></a>
    <div class="popup-content">
        <div class="popup-title">Свободные даты для бронирования</div>
        <p class="freedate-sub"><?=$arParams["ITEM_NAME"]?></p>
        <div id="two-inputs_inline">
            <div style="display: none">
                <input id="date-range100" class="date-range" size="20" value="">
                <input id="date-range101" class="date-range" size="20" value="">
            </div>
            <div id="date-range-container"></div>
        </div>
        <div class="popup-attention">При изменении дат выбранные велосипеды сбрасываются.</div>
        <div class="form-line center"><a class="b-button button_fill button_big button_accept">Применить</a></div>
    </div>
</div>
