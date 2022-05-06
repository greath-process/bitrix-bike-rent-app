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
date_default_timezone_set('Asia/Dubai');
?>
<section class="b-filter">
    <div class="b-container">
        <div class="sect-gray">
            <div class="filter-head">
                <h1 class="filter-head__title"><?= GetMessage('TITLE');?></h1>
                <div class="filter-head__gift">
                    <div class="gift">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/helmet.php"
                            )
                        );?>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/lighter.php"
                            )
                        );?><?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            "",
                            Array(
                                "AREA_FILE_SHOW" => "file",
                                "AREA_FILE_SUFFIX" => "inc",
                                "EDIT_TEMPLATE" => "",
                                "PATH" => "/include/lock.php"
                            )
                        );?>
                    </div>
                </div>
            </div>
            <div class="filter-parametr">
                <div class="parametrs">
                    <div class="parametrs-item">
                        <div class="parametrs-item__title"><?= GetMessage('RENT_TYPE');?></div>
                        <div class="parametrs-item__check">
                            <div class="p-check_wrap">
                                <?$first = true;
                                foreach ($arResult["LEASE"] as $key=>$lease):?>
                                    <input class="p-check__radio" type="radio" name="param__arend"
                                           id="param__arend<?=$lease['ID']?>"
                                        <?if($_GET["back"] && $_SESSION["param__arend"] == $lease['UF_XML_ID']){
                                            $first = false;
                                            echo " checked";
                                        }?>
                                        <?if($first) echo ' checked';?>
                                           data-id="<?=$lease['UF_XML_ID']?>" value="<?=$lease['UF_XML_ID']?>" />
                                    <label class="p-check" <?if(count($arResult["LEASE"]) < 2) echo 'style="width:100%;"'?> for="param__arend<?=$lease['ID']?>">
                                        <span class="p-check__text"><?=$lease['UF_NAME']?></span>
                                    </label>
                                <?$first = false;
                                endforeach;?>
<!--                                <div class="naveden"></div>-->
                            </div>
                        </div>
                    </div>
                    <div class="parametrs-item parametrs-item_delivery">
                        <div class="parametrs-item__title"><?= GetMessage('DELIVERY');?></div>
                        <div class="parametrs-item__select">
                            <select name="param__delivery" class="b-select chosen-select">
                                <?foreach ($arResult["DELIVERY"] as $delivery):?>
                                    <option <?if($_GET["back"] && $_SESSION["type_delivery"] == $delivery["UF_VALUE"]) echo "selected";?> value="<?=$delivery["UF_VALUE"]?>"><?=$delivery["UF_NAME"]?></option>
                                <?endforeach;?>
                            </select>
                        </div>
                    </div>
                    <input type="hidden" name="start_worktime" value="<?=BEGIN_WORKTIME?>">
                    <input type="hidden" name="end_worktime" value="<?=END_WORKTIME?>">
                    <div class="parametrs-item parametrs-item_date" id="two-inputs">
                        <div class="parametrs-item__data">
                            <div class="parametrs-item__title"><?= GetMessage('TIMESTAMP_START');?></div>
                            <div class="parametrs-item__range">
                                <input id="date-range200" name="data_start" type="text" class="date-range" size="20" readonly value="<?if($_GET["back"]) echo $_SESSION["data_start"]; else echo date("d.m.Y H:i", mktime(date("H")+1, date("i"), 0, date("m"), date("d"), date("Y")));?>"> <!--14.07.2021 22:22-->
                            </div>
                        </div>
                        <div class="tire">—</div>
                        <div class="parametrs-item__data">
                            <div class="parametrs-item__title"><?= GetMessage('TIMESTAMP_END');?></div>
                            <div class="parametrs-item__range">
                                <input id="date-range201" name="data_end" type="text" class="date-range" size="20" readonly value="<?if($_GET["back"]) echo $_SESSION["data_end"]; else echo date("d.m.Y H:i", mktime(date("H")+1, date("i"), 0, date("m"), date("d")+1, date("Y")));?>">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="b-ftype">
    <div class="b-container">
        <div class="ftype sect-gray sect-perehoc">
            <div class="ftype__title"><?= GetMessage('BIKE_TYPE');?></div>
            <div class="fbike_scrol">
                <div class="mob-hand"></div>
                <div class="fbike-wrap">
                    <div class="ftype__fbike">
                        <div class="fbike">
                            <?foreach ($arResult["SECTIONS"] as $arSection):?>
                                <div class="fbike-item">
                                    <div class="fbike-item__img">
                                        <img class="fbike-img" src="<?=CFILE::GetPath($arSection["PICTURE"]);?>" alt="<?=$arSection["NAME"]?>"/>
                                    </div>
                                    <div class="fbike-item__info">
                                        <div class="fbike-item__title"><?=$arSection["NAME"]?></div>
                                        <div class="finfo">
                                            <div class="price" id="days"><?=$arSection["UF_PRICE_FOR_DAY"]?></div>
                                            <div class="price" id="hours" style="display: none"><?=$arSection["UF_PRICE_FOR_HOURS"]?></div>
                                            <div class="finfo__fbut">
                                                <div class="fbut">
                                                    <div class="fbut__question">
                                                        <a class="question but-qvad"></a>
                                                        <div class="hint">
                                                            <?=$arSection["DESCRIPTION"]?>
                                                        </div>
                                                    </div>
                                                    <div class="fbut__plus">
                                                        <input type="checkbox"
                                                               class="checkbox"
                                                               name="sections[]"
                                                               id="plus<?=$arSection["ID"]?>"
                                                               value="<?=$arSection["ID"]?>"
                                                                <?if($_GET["back"] && $_SESSION["sections"][$arSection["ID"]] == $arSection["ID"])
                                                                    echo "checked";?>
                                                        >
                                                        <label class="plus but-qvad" for="plus<?=$arSection["ID"]?>"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?endforeach;?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="b-submit ftype_submit">
                <input class="b-button button_fill button_big b-button_submit" id="searchItems" type="submit" value="<?= GetMessage('FIND');?>">
            </div>
        </div>
    </div>
</section>
<?//echo htmlspecialchars($_GET["back"]);?>
<script>
    <?if($_GET["back"]):?>
        $(document).ready(function (){
            $('#searchItems').click();
        })
    <?endif?>
</script>
<section class="loader">
<div class=" b-container"
     style="
             background: url('<?=SITE_TEMPLATE_PATH;?>/img/ajax-loader.gif') no-repeat center;
             background-size: contain;">
</div>
</section>