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
<? if (count($arResult["ITEMS"]) > 0) : ?>
    <?
    $arItem = $arResult["ITEM"];
    $type_rent = $arItem['PROPERTIES']['TYPE_AREND']['VALUE']
    ?>
    <section>
        <div class="b-container">
            <div class="sect-gray">
                <h1 class="other-page"><?= $APPLICATION->GetTitle() ?></h1>
                <div class="filter-parametr filter_prodlen">
                    <div class="parametrs parametr_prodlen" data-type-rent="<?= $type_rent ?>">
                        <input type="hidden" name="ORDER_ID" value="<?= $arItem['ID'] ?>">
                        <div id="price_list" style="display:none;">
                            <? foreach ($arItem["PROPERTIES"]["ITEMS"]["VALUE"] as $ID) : ?>
                                <div><?= $arResult["MY_ITEMS"][$ID]["PRICE_FOR_" . strtoupper($type_rent)]; ?></div>
                            <? endforeach; ?>
                        </div>
                        <? if ($type_rent == "days") : // по дням
                        ?>
                            <div class="parametrs-item_100">
                                <div class="parametrs-item parametrs-item_date ">
                                    <div class="parametrs-item__data">
                                        <div class="parametrs-item__title"><?=GetMessage('TIMESTAMP_START')?></div>
                                        <div class="parametrs-item__range"><input id="date-range200" readonly disabled class="date-range" size="20" value="<?= substr($arItem['PROPERTIES']['DATE_END']['VALUE'], 0, -3) ?>"></div>
                                    </div>
                                    <div class="tire">—</div>
                                    <div class="parametrs-item__data">
                                        <div class="parametrs-item__title"><?=GetMessage('TIMESTAMP_END')?></div>
                                        <div class="parametrs-item__range"><input id="inputssingle" class="date-range" size="20" value="<?= substr($arItem['PROPERTIES']['DATE_END']['VALUE'], 0, -3) ?>"></div>
                                    </div>
                                </div>
                            </div>

                            <script>
                                $(document).ready(function() {

                                    if ($("*").is("#inputssingle")) {
                                        var disabledDates = [];
                                        <? if (count($arResult["DISABLED_DATES"]) > 0) : ?>
                                            //var disabledDates = <? //=CUtil::PhpToJSObject($arResult["DISABLED_DATES"]);
                                                                    ?>//;
                                            var str_arr = "<?= implode(",", array_values($arResult["DISABLED_DATES"])) ?>";
                                            var disabledDates = str_arr.split(",")
                                        <? endif ?>
                                        console.log(disabledDates);
                                        $('#inputssingle').dateRangePicker({
                                            format: 'DD.MM.YYYY HH:mm',
                                            startOfWeek: 'monday',
                                            language: 'en',
                                            hoveringTooltip: false,
                                            monthSelect: true,
                                            yearSelect: false,
                                            alwaysOpen: false,

                                            startDate: '<?= substr($arItem['PROPERTIES']['DATE_END']['VALUE'], 0, -3) ?>',

                                            autoClose: false,
                                            singleDate: true,
                                            singleMonth: true,

                                            time: {
                                                enabled: true
                                            },
                                            beforeShowDay: function(date) {
                                                var currDate = moment(date).format('DD.MM.YYYY');
                                                return [disabledDates.indexOf(currDate) == -1];
                                            }
                                        }).bind('datepicker-change', function(event, obj) {
                                            var date1 = moment($('.parametr_prodlen #date-range200').val(), 'DD.MM.YYYY HH:mm');
                                            var date2 = moment(obj.value, 'DD.MM.YYYY HH:mm');
                                            var diffDays = date2.diff(date1, 'days');
                                            var total = 0;
                                            $('#price_list').find('div').each(function() {
                                                var price = parseInt($(this).html());
                                                total += price * diffDays;
                                            })
                                            $('#price_exetend').html(total + ' AED');
                                            var total_price = parseInt($('#price_exetend').html());
                                            if (total_price > 0 && diffDays > 0) {
                                                $('#button_exetend').prop('disabled', false);
                                                $('#button_exetend').removeClass('button_gray');

                                            } else {
                                                $('#button_exetend').prop('disabled', true);
                                                $('#button_exetend').addClass('button_gray');
                                            }

                                        });
                                    }
                                    $('.time1 .vremya').find('input').prop('readonly', true);
                                })
                            </script>
                        <? else : // по часам
                        ?>
                            <input type="hidden" name="DATE_END" value="<?= substr($arItem['PROPERTIES']['DATE_END']['VALUE'], 0, -3) ?>">
                            <div class="parametrs-item parametrs-item_50">
                                <div class="parametrs-item__title"><?= GetMessage('RENEW_VALUE')?>:</div>
                                <div class="parametrs-item__select">
                                    <select name="hours_select" id="hours_select" class="b-select chosen-select">
                                        <? for ($i = 2; $i <= 6; $i += 2) : ?>
                                            <option value="<?= $i ?>" <?
                                                                    $start_work = strtotime(date('Y-m-d')  . " " . BEGIN_WORKTIME);
                                                                    $end_work = strtotime(date('Y-m-d')  . " " . END_WORKTIME);
                                                                    $time_end = explode(' ', substr($arItem['PROPERTIES']['DATE_END']['VALUE'], 0, -3))[1];
                                                                    $currentTime  = strtotime(date('Y-m-d')  . " " . $time_end . "+" . ($i + 1) . " hours");
                                                                    if ($currentTime >= $end_work || $currentTime <= $start_work)
                                                                        echo "disabled";
                                                                    ?>>
                                                <?= $i ?> <?= GetMessage('HOUR')?>
                                            </option>
                                        <? endfor; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="parametrs-item parametrs-item_50">
                                <div class="parametrs-item__title"><?= GetMessage('NEW_DATE_RETURN')?>:</div>
                                <div class="parametrs-item__input">
                                    <input class="input" id="returnIn" readonly disabled type="text" value="" />
                                </div>
                            </div>
                        <? endif; ?>
                        <div class="parametrs-item parametrs-item_100">
                            <div class="sub-info__text"><?= GetMessage('PAYMENT_METHOD')?></div>
                            <div class="form-line form-line_radio">
                                <? $first = true;
                                foreach ($arResult["PAYMENT"] as $pay) : ?>
                                    <div class="form-radio form-radio_margbot form-radio_checkout">
                                        <input type="radio" <? if ($first == true) echo "checked"; ?> name="PAYMENT_SYSTEM" class="radio" id="radio-<?= $pay["ID"] ?>" data-id="<?= $pay["ID"] ?>" value="<?= $pay["ID"] ?>">
                                        <label class="label-radio label-radio_checkout" for="radio-<?= $pay["ID"] ?>">
                                            <span class="radiokrug"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <circle cx="16" cy="16" r="15.5" stroke="#DDE3EB"></circle>
                                                    <circle cx="15.9999" cy="15.9997" r="10.6667" fill="currentcolor"></circle>
                                                </svg></span>
                                            <?= $pay["UF_NAME"] ?>
                                            <? if (!empty($pay["UF_DESCRIPTION"])) : ?>
                                                <div class="radio-question">
                                                    <a class="question but-qvad" tabindex="0"></a>
                                                    <div class="hint hint_radio"><?= $pay["UF_DESCRIPTION"] ?></div>
                                                </div>
                                            <? endif; ?>
                                        </label>
                                    </div>
                                <? $first = false;
                                endforeach; ?>
                            </div>
                        </div>
                        <div class="parametrs-item parametrs-item_50">
                            <div class="parametrs-item__title"><?= GetMessage('SUM_ADD')?></div>
                            <div class="price" id="price_exetend">0 AED</div>
                        </div>
                        <div class="parametrs-item parametrs-item_50">
                        </div>
                        <div class="parametrs-item parametrs-item_50 prodlen-link">
                            <button type="button" id="button_exetend" class="b-button button_gray button_fill button_big b-button_prodlen" disabled><?= GetMessage('RENEW_ACTION')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
<? endif; ?>