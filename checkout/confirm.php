<?
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("Your order has been successfully completed");
?>
<?
CModule::IncludeModule('iblock');
$orderId = intval($_GET["ORDER_ID"]);

if($orderId > 0):

/* свойства */
$PROP = array();
$res = CIBlockElement::GetProperty(ORDER_IBLOCK, $orderId, "sort", "asc", array());
while ($ob = $res->GetNext())
{
    if($ob["CODE"] == "ITEMS")
        $PROP[$ob["CODE"]][] = $ob['VALUE'];
    else
        $PROP[$ob["CODE"]] = $ob['VALUE'];
}

/* товары в заказе */
$arSelect = Array("ID", "IBLOCK_ID", "NAME", "PREVIEW_PICTURE", "DATE_ACTIVE_FROM", "PROPERTY_*");
$arFilter = Array("IBLOCK_ID"=>RENT_IBLOCK, "ID"=>$PROP["ITEMS"]);
$rsItems = CIBlockElement::GetList(Array(), $arFilter, false, Array("nPageSize"=>50), $arSelect);
while($Item = $rsItems->GetNextElement()) {
    $arFields = $Item->GetFields();
    $arProps = $Item->GetProperties();
    $arResult["ITEMS"][$arFields["ID"]] = $arFields;
    $arResult["ITEMS"][$arFields["ID"]]["PROPERTIES"] = $arProps;
}

/* Доставка */
$entity_data_class = GetEntityDataClass(HLB_DELIVERY_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'order' => array('UF_SORT' => 'ASC'),
    'filter' => array('UF_XML_ID'=> $PROP['DELIVERY'])
));
if ($el = $rsData->fetch()) {
    $arResult["DELIVERY"] = $el;
}

/* Оплата */
$entity_data_class = GetEntityDataClass(HLB_PAYMENT_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'order' => array('UF_SORT' => 'ASC'),
    'filter' => array('UF_XML_ID'=> $PROP['PAYMENT_SYSTEM'])
));
if ($el = $rsData->fetch()) {
    $arResult["PAYMENT"] = $el;
}
?>
	<section>
		<div class="b-container">
			<div class="sect-gray sect-done">
				<h1 class="other-page other-page_order">Your order has been successfully completed</h1>
				<div class="order-info">
					<div class="sub-info order-info__item">
						<div class="sub-info__text">Rental type</div>
						<div class="sub-info__value">
                            <?if($PROP['TYPE_AREND'] == "hours")
                                echo "2 hours";
                            else
                                echo "By days";
                            ?>
                        </div>
					</div>
					<div class="sub-info order-info__item order-info_order1">
						<div class="sub-info__text">The lease start</div>
						<div class="sub-info__value"><?=$PROP['DATE_START']?></div>
					</div>
					<div class="sub-info order-info__item order-info_order2">
						<div class="sub-info__text">The lease end</div>
						<div class="sub-info__value"><?=$PROP['DATE_END']?></div>
					</div>
					<div class="sub-info order-info__item">
						<div class="sub-info__text">Delivery</div>
						<div class="sub-info__value"><?=$arResult["DELIVERY"]["UF_NAME"]?></div>
					</div>
					<div class="sub-info order-info__item order-info_order3">
						<div class="sub-info__text">Payment method</div>
						<div class="sub-info__value"><?=$arResult["PAYMENT"]["UF_NAME"]?></div>
					</div>
				</div>
				<div class="order-table order-table_done">
					<div class="order-items order-line_title">
						<div class="order-imgname">
							<div class="sub-text order-item order-item_img"></div>
							<div class="sub-text order-item order-item_namecheck">Bicycle name</div>
						</div>
						<div class="sub-text order-item order-item_price text-right">Value</div>
					</div>
                    <?foreach ($arResult["ITEMS"] as $arItem):?>
					<div class="order-items">
						<div class="order-imgname">
							<div class="order-item order-item_img">
								<div class="table-img">
                                    <img src="<?=CFile::GetPath($arItem['PREVIEW_PICTURE'])?>" alt="<?=$arItem['NAME']?>">
                                </div>
							</div>
							<div class="order-item order-item_namecheck"><?=$arItem['NAME']?></div>
						</div>
						<div class="order-item order-item_price order-item_stoimost text-right">
                            <div class="price price_order">
                                <?=$arItem['PROPERTIES']['PRICE_FOR_'.strtoupper($PROP['TYPE_AREND'])]['VALUE']?>
                            </div>
                        </div>
					</div>
                    <?endforeach;?>
				</div>
				<div class="order-total">
					<div class="order-ship">
						<div class="order-ship__line">
							<div class="sub-text">Delivery</div>
							<div class="order-ship__value text-right">
                                <div class="price price_ship"><?=$PROP['PRICE_DELIVERY']?></div>
                            </div>
						</div>
						<div class="order-ship__line">
							<div class="sub-text">Total</div>
							<div class="order-ship__value text-right">
                                <div class="price"><?=$PROP['PRICE']?></div>
                            </div>
						</div>
					</div>
					<div class="order-total__back"></div>
				</div>
				<div class="order-link center">
					<a href="/personal/" class="b-button button_fill button_big b-button_order">To personal account</a>
					<a href="/" class="b-button button_space button_big b-button_order">Back to homepage</a>
				</div>
			</div>
		</div>
	</section>
<?endif;?>
<?require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>