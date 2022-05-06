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
        <div class="sect-gray">
            <h1 class="other-page"><?=$APPLICATION->ShowTitle()?></h1>
            <div class="filter-parametr">
                <form method="post" id="admin_filters" enctype="multipart/form-data">
                    <div class="parametrs parametrs_multiline">
                        <div class="parametrs-item parametrs-item_date" id="two-inputs-admin">
                            <div class="parametrs-item__data">
                                <div class="parametrs-item__title">Дата и время начала</div>
                                <div class="parametrs-item__range">
                                    <input class="date-range" id="date-range300" name="param__date_start" type="text" autocomplete="off" size="20" value="<?=$_SESSION["admin_filter"]["param__date_start"]?>">
                                </div>
                            </div>
                            <div class="parametrs-item__data">
                                <div class="parametrs-item__title">Дата и время конца</div>
                                <div class="parametrs-item__range">
                                    <input class="date-range" id="date-range301" name="param__date_end" autocomplete="off" type="text" size="20" value="<?=$_SESSION["admin_filter"]["param__date_end"]?>">
                                </div>
                            </div>
                        </div>
                        <div class="parametrs-item">
                            <div class="parametrs-item__data" style="width: 100%; padding: 0;">
                                <div class="parametrs-item__title">Фактическая дата возврата</div>
                                <div class="parametrs-item__range">
                                    <input id="single-inputs-admin" class="date-range" name="param__date_return" autocomplete="off" type="text" size="20" value="<?=$_SESSION["admin_filter"]["param__date_return"]?>">
                                </div>
                            </div>
                        </div>
                        <div class="parametrs-item">
                            <div class="parametrs-item__title">Статус заказа</div>
                            <div class="parametrs-item__select">
                                <select class="b-select chosen-select" name="param__status">
                                    <option value="all">Все</option>
                                    <?foreach ($arResult["STATUS"] as $status):?>
                                        <option value="<?=$status["ID"]?>" <?if($_SESSION["admin_filter"]["param__status"] == $status["ID"]) echo "selected"?>><?=$status["NAME"]?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="parametrs-item">
                            <div class="parametrs-item__title">Тип аренды</div>
                            <div class="parametrs-item__select">
                                <select class="b-select chosen-select" name="param__arend">
                                    <option value="all">Все</option>
                                    <?foreach ($arResult["LEASE"] as $key=>$lease):?>
                                        <option value="<?=$lease['UF_XML_ID']?>" <?if($_SESSION["admin_filter"]["param__arend"] == $lease['UF_XML_ID']) echo "selected"?>><?=$lease['UF_NAME']?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="parametrs-item">
                            <div class="parametrs-item__title">Тип доставки</div>
                            <div class="parametrs-item__select">
                                <select class="b-select chosen-select" name="param__delivery">
                                    <option value="all">Все</option>
                                    <?foreach ($arResult["DELIVERY"] as $delivery):?>
                                        <option value="<?=$delivery["UF_VALUE"]?>" <?if($_SESSION["admin_filter"]["param__delivery"] == $delivery["UF_VALUE"]) echo "selected"?>><?=$delivery["UF_NAME"]?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="parametrs-item">
                            <div class="parametrs-item__title">Тип оплаты</div>
                            <div class="parametrs-item__select">
                                <select class="b-select chosen-select" name="param__payment">
                                    <option value="all">Все</option>
                                    <?foreach ($arResult["PAYMENT"] as $pay):?>
                                        <option value="<?=$pay["UF_XML_ID"]?>" <?if($_SESSION["admin_filter"]["param__payment"] == $pay["UF_XML_ID"]) echo "selected"?>><?=$pay["UF_NAME"]?></option>
                                    <?endforeach;?>
                                </select>
                            </div>
                        </div>
                        <div class="parametrs-item">
                            <div class="parametrs-item__title">Статус оплаты</div>
                            <div class="parametrs-item__select">
                                <select class="b-select chosen-select" name="param__paid">
                                    <option value="all">Все</option>
                                    <option value="Y"<?if($_SESSION["admin_filter"]["param__paid"] == "Y") echo "selected"?>>Оплачен</option>
                                    <option value=""<?if(empty($_SESSION["admin_filter"]["param__paid"]) && isset($_SESSION["admin_filter"]["param__paid"])) echo "selected"?>>Не оплачен</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="filter-parametr__footer">
                        <button type="submit" class="b-button button_fill button_big b-button_action">Найти</button>
                        <button type="button" id="del_admin_filter" class="b-button button_space button_big b-button_action">Сбросить фильтр</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<section class="loader">
<div class=" b-container"
     style="
             background: url('<?=SITE_TEMPLATE_PATH;?>/img/ajax-loader.gif') no-repeat center;
             background-size: contain;">
</div>
</section>