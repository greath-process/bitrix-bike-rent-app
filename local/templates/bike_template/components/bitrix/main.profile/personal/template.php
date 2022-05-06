<?

/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
    die();

if ($arResult["SHOW_SMS_FIELD"] == true) {
    CJSCore::Init('phone_auth');
}
?>

<? ShowError($arResult["strProfileError"]); ?>
<?
if ($arResult['DATA_SAVED'] == 'Y')
    ShowNote(GetMessage('PROFILE_DATA_SAVED'));
?>

<? if ($arResult["SHOW_SMS_FIELD"] == true) : ?>

    <form method="post" action="<?= $arResult["FORM_TARGET"] ?>" enctype="multipart/form-data">
        <?= $arResult["BX_SESSION_CHECK"] ?>
        <input type="hidden" name="lang" value="<?= LANG ?>" />
        <input type="hidden" name="ID" value=<?= $arResult["ID"] ?> />
        <input type="hidden" name="SIGNED_DATA" value="<?= htmlspecialcharsbx($arResult["SIGNED_DATA"]) ?>" />
        <table class="profile-table data-table">
            <tbody>
                <tr>
                    <td><? echo GetMessage("main_profile_code") ?><span class="starrequired">*</span></td>
                    <td><input size="30" type="text" name="SMS_CODE" value="<?= htmlspecialcharsbx($arResult["SMS_CODE"]) ?>" autocomplete="off" /></td>
                </tr>
            </tbody>
        </table>

        <p><input type="submit" name="code_submit_button" value="<? echo GetMessage("main_profile_send") ?>" /></p>

    </form>

    <script>
        new BX.PhoneAuth({
            containerId: 'bx_profile_resend',
            errorContainerId: 'bx_profile_error',
            interval: <?= $arResult["PHONE_CODE_RESEND_INTERVAL"] ?>,
            data: <?= CUtil::PhpToJSObject([
                        'signedData' => $arResult["SIGNED_DATA"],
                    ]) ?>,
            onError: function(response) {
                var errorDiv = BX('bx_profile_error');
                var errorNode = BX.findChildByClassName(errorDiv, 'errortext');
                errorNode.innerHTML = '';
                for (var i = 0; i < response.errors.length; i++) {
                    errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br>';
                }
                errorDiv.style.display = '';
            }
        });
    </script>

    <div id="bx_profile_error" style="display:none"><? ShowError("error") ?></div>

    <div id="bx_profile_resend"></div>

<? else : ?>

    <script type="text/javascript">
        // <!--
        var opened_sections = [<?
                                $arResult["opened"] = $_COOKIE[$arResult["COOKIE_PREFIX"] . "_user_profile_open"];
                                $arResult["opened"] = preg_replace("/[^a-z0-9_,]/i", "", $arResult["opened"]);
                                if ($arResult["opened"] <> '') {
                                    echo "'" . implode("', '", explode(",", $arResult["opened"])) . "'";
                                } else {
                                    $arResult["opened"] = "reg";
                                    echo "'reg'";
                                }
                                ?>];
        //-->

        var cookie_prefix = '<?= $arResult["COOKIE_PREFIX"] ?>';
    </script>
    <form method="post" name="form1" action="<?= $arResult["FORM_TARGET"] ?>" class="view" enctype="multipart/form-data">
        <?= $arResult["BX_SESSION_CHECK"] ?>
        <input type="hidden" name="lang" value="<?= LANG ?>" />
        <input type="hidden" name="ID" value=<?= $arResult["ID"] ?> />

        <div class="block-col">
            <div class="col4-item">
                <div class="sub-info">
                    <div class="sub-info__text"><?= GetMessage('NAME') ?></div>
                    <div class="form-line">
                        <input type="text" class="input" name="NAME" maxlength="50" value="<?= $arResult["arUser"]["NAME"] ?>" readonly />
                    </div>
                </div>
                <div class="sub-info">
                    <div class="sub-info__text"><?= GetMessage('USER_PHONE') ?></div>
                    <div class="form-line">
                        <input type="text" class="input masc-phone" name="PERSONAL_PHONE" maxlength="255" value="<?= $arResult["arUser"]["PERSONAL_PHONE"] ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="col4-item mob-marg">
                <div class="sub-info">
                    <div class="sub-info__text"><?= GetMessage('EMAIL') ?><? if ($arResult["EMAIL_REQUIRED"]) : ?><span class="starrequired">*</span><? endif ?></div>
                    <div class="form-line">
                        <input type="text" class="input" name="EMAIL" maxlength="50" value="<?= $arResult["arUser"]["EMAIL"] ?>" readonly />
                    </div>
                </div>
                <div class="sub-info">
                    <? $address = $arResult["USER_PROPERTIES"]["DATA"]["UF_ADDRESS_DELIVERY"]; ?>
                    <div class="sub-info__text"><?= $address["EDIT_FORM_LABEL"] ?>
                        <? if ($address["MANDATORY"] == "Y") : ?><span class="starrequired">*</span><? endif; ?>
                    </div>
                    <div class="form-line">
                        <input type="text" class="input" name="UF_ADDRESS_DELIVERY" value="<?= $address["VALUE"] ?>" readonly />
                    </div>
                </div>
            </div>
            <div class="col4-item col4-item_pass mob-marg viewblock">
                <div class="lk-col lk-changepass">
                    <div class="sub-info sub-info_col6">
                        <div class="sub-info__text"><?= GetMessage('PASSWORD') ?></div>
                        <div class="sub-info__value">*************</div>
                    </div>
                    <div class="sub-info sub-info_col6 pass_hide">
                    </div>
                </div>
            </div>
            <? if ($arResult['CAN_EDIT_PASSWORD']) : ?>
                <div class="col4-item col4-item_pass hideblock">
                    <h2 class="pass-mob">Change password</h2>
                    <div class="lk-col mob-marg lk-changepass">
                        <div class="sub-info sub-info_col6">
                            <div class="sub-info__text"><?= GetMessage('NEW_PASSWORD_REQ') ?></div>
                            <div class="form-line form-line_pass">
                                <input type="password" class="input" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" readonly />
                                <a class="password-control" href="#"></a>
                            </div>
                        </div>
                        <? if ($arResult["SECURE_AUTH"]) : ?>
                            <span class="bx-auth-secure" id="bx_auth_secure" title="<? echo GetMessage("AUTH_SECURE_NOTE") ?>" style="display:none">
                                <div class="bx-auth-secure-icon"></div>
                            </span>
                            <noscript>
                                <span class="bx-auth-secure" title="<? echo GetMessage("AUTH_NONSECURE_NOTE") ?>">
                                    <div class="bx-auth-secure-icon bx-auth-secure-unlock"></div>
                                </span>
                            </noscript>
                            <script type="text/javascript">
                                document.getElementById('bx_auth_secure').style.display = 'inline-block';
                            </script>
                        <? endif ?>
                        <div class="sub-info sub-info_col6">
                            <div class="sub-info__text"><?= GetMessage('NEW_PASSWORD_CONFIRM') ?></div>
                            <div class="form-line form-line_pass">
                                <input type="password" class="input" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" readonly />
                                <a class="password-control" href="#"></a>
                            </div>
                        </div>
                    </div>
                </div>
            <? endif ?>
        </div>
        <div class="lk-leftbutton">
            <input type="submit" style="display: none" class="b-button button_fill button_big b-button_submit b-button_save" name="save" value="<?= (($arResult["ID"] > 0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD")) ?>">
            <a id="edit_btn" class="b-button button_fill button_big b-button_edit"><?= GetMessage('edit_data') ?></a>
        </div>
        <!--	<p><input type="submit" name="save" value="--><? //=(($arResult["ID"]>0) ? GetMessage("MAIN_SAVE") : GetMessage("MAIN_ADD"))
                                                                ?>
        <!--">&nbsp;&nbsp;<input type="reset" value="--><? //=GetMessage('MAIN_RESET');
                                                        ?>
        <!--"></p>-->
    </form>

<? endif ?>