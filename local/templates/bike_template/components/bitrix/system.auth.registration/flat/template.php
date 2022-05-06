<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponentTemplate $this
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();
ShowMessage($arParams["~AUTH_RESULT"]);
?>

<?$APPLICATION->IncludeComponent(
            "bitrix:main.register",
            "popup",
            Array(
                "AUTH" => "Y",
                "REQUIRED_FIELDS" => array("EMAIL", "NAME", "PERSONAL_PHONE"),
                "SET_TITLE" => "Y",
                "SHOW_FIELDS" => array("EMAIL", "NAME", "PERSONAL_PHONE"),
                "SUCCESS_PAGE" => "",
                "USER_PROPERTY" => array(),
                "USER_PROPERTY_NAME" => "",
                "USE_BACKURL" => "Y"
            )
        );?>
<?php
/*
if($arResult["SHOW_SMS_FIELD"] == true)
{
	CJSCore::Init('phone_auth');
}

//one css for all system.auth.* forms
$APPLICATION->SetAdditionalCSS("/bitrix/css/main/system.auth/flat/style.css");
*/?><!--
<div class="bx-authform" id="flat">
    <h3 class="bx-title"><?/*=GetMessage("AUTH_REGISTER")*/?></h3>
<noindex>

<?/*
if(!empty($arParams["~AUTH_RESULT"])):
	$text = str_replace(array("<br>", "<br />"), "\n", $arParams["~AUTH_RESULT"]["MESSAGE"]);
*/?>
	<div class="alert <?/*=($arParams["~AUTH_RESULT"]["TYPE"] == "OK"? "alert-success":"alert-danger")*/?>"><?/*=nl2br(htmlspecialcharsbx($text))*/?></div>
<?/*endif*/?>

<?/*if($arResult["SHOW_EMAIL_SENT_CONFIRMATION"]):*/?>
	<div class="alert alert-success"><?/*echo GetMessage("AUTH_EMAIL_SENT")*/?></div>
<?/*endif*/?>

<?/*if(!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"] && $arResult["USE_EMAIL_CONFIRMATION"] === "Y"):*/?>
	<div class="alert alert-warning"><?/*echo GetMessage("AUTH_EMAIL_WILL_BE_SENT")*/?></div>
<?/*endif*/?>

<?/*if($arResult["SHOW_SMS_FIELD"] == true):*/?>

<form method="post" action="<?/*=$arResult["AUTH_URL"]*/?>" name="regform">

	<input type="hidden" name="SIGNED_DATA" value="<?/*=htmlspecialcharsbx($arResult["SIGNED_DATA"])*/?>" />

	<div class="bx-authform-formgroup-container">
		<div class="bx-authform-label-container"><span class="bx-authform-starrequired">*</span><?/*echo GetMessage("main_register_sms_code")*/?></div>
		<div class="bx-authform-input-container">
			<input type="text" name="SMS_CODE" maxlength="255" value="<?/*=htmlspecialcharsbx($arResult["SMS_CODE"])*/?>" autocomplete="off" />
		</div>
	</div>

	<div class="bx-authform-formgroup-container">
		<input type="submit" class="b-button button_fill button_big b-button_submit b-button_avtoriz" name="code_submit_button" value="<?/*echo GetMessage("main_register_sms_send")*/?>" />
	</div>

</form>

<script>
new BX.PhoneAuth({
	containerId: 'bx_register_resend',
	errorContainerId: 'bx_register_error',
	interval: <?/*=$arResult["PHONE_CODE_RESEND_INTERVAL"]*/?>,
	data:
		<?/*=CUtil::PhpToJSObject([
			'signedData' => $arResult["SIGNED_DATA"],
		])*/?>,
	onError:
		function(response)
		{
			var errorNode = BX('bx_register_error');
			errorNode.innerHTML = '';
			for(var i = 0; i < response.errors.length; i++)
			{
				errorNode.innerHTML = errorNode.innerHTML + BX.util.htmlspecialchars(response.errors[i].message) + '<br />';
			}
			errorNode.style.display = '';
		}
});
</script>

<div id="bx_register_error" style="display:none" class="alert alert-danger"></div>

<div id="bx_register_resend"></div>

<?/*elseif(!$arResult["SHOW_EMAIL_SENT_CONFIRMATION"]):*/?>

	<form method="post" action="<?/*=$arResult["AUTH_URL"]*/?>" name="bform" enctype="multipart/form-data">
		<input type="hidden" name="AUTH_FORM" value="Y" />
		<input type="hidden" name="TYPE" value="REGISTRATION" />

		<div class="sub-info">
			<div class="sub-info__text"><span class="bx-authform-starrequired">*</span><?/*=GetMessage("AUTH_NAME")*/?></div>
			<div class="form-line">
				<input type="text" class="input" name="USER_NAME" maxlength="255" value="<?/*=$arResult["USER_NAME"]*/?>" />
			</div>
		</div>

		<div class="sub-info">
			<div class="sub-info__text"><span class="bx-authform-starrequired">*</span><?/*=GetMessage("AUTH_PHONE")*/?></div>
			<div class="form-line">
				<input type="text" class="input" name="PERSONAL_PHONE" maxlength="255" value="<?/*=$arResult["USER_PERSONAL_PHONE"]*/?>" />
			</div>
		</div>

        <?/*if($arResult["EMAIL_REGISTRATION"]):*/?>
            <div class="sub-info">
                <div class="sub-info__text"><?/*if($arResult["EMAIL_REQUIRED"]):*/?><span class="bx-authform-starrequired">*</span><?/*endif*/?><?/*=GetMessage("AUTH_EMAIL")*/?></div>
                <div class="form-line">
                    <input type="text" class="input" name="USER_EMAIL" maxlength="255" value="<?/*=$arResult["USER_EMAIL"]*/?>" />
                </div>
            </div>
        <?/*endif*/?>

		<div class="sub-info">
			<div class="sub-info__text"><span class="bx-authform-starrequired">*</span><?/*=GetMessage("AUTH_PASSWORD_REQ")*/?></div>
			<div class="form-line form-line_pass">
<?/*if($arResult["SECURE_AUTH"]):*/?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?/*echo GetMessage("AUTH_SECURE_NOTE")*/?></div></div>

<script type="text/javascript">
document.getElementById('bx_auth_secure').style.display = '';
</script>
<?/*endif*/?>
				<input type="password" class="input" name="USER_PASSWORD" maxlength="255" value="<?/*=$arResult["USER_PASSWORD"]*/?>" autocomplete="off" />
                <a class="password-control" href="#"></a>
			</div>
		</div>

		<div class="sub-info">
			<div class="sub-info__text"><span class="bx-authform-starrequired">*</span><?/*=GetMessage("AUTH_CONFIRM")*/?></div>
			<div class="form-line form-line_pass">
<?/*if($arResult["SECURE_AUTH"]):*/?>
				<div class="bx-authform-psw-protected" id="bx_auth_secure_conf" style="display:none"><div class="bx-authform-psw-protected-desc"><span></span><?/*echo GetMessage("AUTH_SECURE_NOTE")*/?></div></div>

<script type="text/javascript">
document.getElementById('bx_auth_secure_conf').style.display = '';
</script>
<?/*endif*/?>
				<input type="password" class="input" name="USER_CONFIRM_PASSWORD" maxlength="255" value="<?/*=$arResult["USER_CONFIRM_PASSWORD"]*/?>" autocomplete="off" />
                <a class="password-control" href="#"></a>
			</div>
		</div>

<?/*if($arResult["PHONE_REGISTRATION"]):*/?>
		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?/*if($arResult["PHONE_REQUIRED"]):*/?><span class="bx-authform-starrequired">*</span><?/*endif*/?><?/*echo GetMessage("main_register_phone_number")*/?></div>
			<div class="bx-authform-input-container">
				<input type="text" name="USER_PHONE_NUMBER" maxlength="255" value="<?/*=$arResult["USER_PHONE_NUMBER"]*/?>" />
			</div>
		</div>
<?/*endif*/?>

<?/*if($arResult["USER_PROPERTIES"]["SHOW"] == "Y"):*/?>
	<?/*foreach ($arResult["USER_PROPERTIES"]["DATA"] as $FIELD_NAME => $arUserField):*/?>

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container"><?/*if ($arUserField["MANDATORY"]=="Y"):*/?><span class="bx-authform-starrequired">*</span><?/*endif*/?><?/*=$arUserField["EDIT_FORM_LABEL"]*/?></div>
			<div class="bx-authform-input-container">
<?/*
$APPLICATION->IncludeComponent(
	"bitrix:system.field.edit",
	$arUserField["USER_TYPE"]["USER_TYPE_ID"],
	array(
		"bVarsFromForm" => $arResult["bVarsFromForm"],
		"arUserField" => $arUserField,
		"form_name" => "bform"
	),
	null,
	array("HIDE_ICONS"=>"Y")
);
*/?>
			</div>
		</div>

	<?/*endforeach;*/?>
<?/*endif;*/?>
<?/*if ($arResult["USE_CAPTCHA"] == "Y"):*/?>
		<input type="hidden" name="captcha_sid" value="<?/*=$arResult["CAPTCHA_CODE"]*/?>" />

		<div class="bx-authform-formgroup-container">
			<div class="bx-authform-label-container">
				<span class="bx-authform-starrequired">*</span><?/*=GetMessage("CAPTCHA_REGF_PROMT")*/?>
			</div>
			<div class="bx-captcha"><img src="/bitrix/tools/captcha.php?captcha_sid=<?/*=$arResult["CAPTCHA_CODE"]*/?>" width="180" height="40" alt="CAPTCHA" /></div>
			<div class="bx-authform-input-container">
				<input type="text" name="captcha_word" maxlength="50" value="" autocomplete="off"/>
			</div>
		</div>

<?/*endif*/?>
		<div class="form-line form-line_lk">
			<div class="bx-authform-label-container">
			</div>
			<div class="bx-authform-input-container">
				<?/*$APPLICATION->IncludeComponent("bitrix:main.userconsent.request", "",
					array(
						"ID" => COption::getOptionString("main", "new_user_agreement", ""),
						"IS_CHECKED" => "Y",
						"AUTO_SAVE" => "N",
						"IS_LOADED" => "Y",
						"ORIGINATOR_ID" => $arResult["AGREEMENT_ORIGINATOR_ID"],
						"ORIGIN_ID" => $arResult["AGREEMENT_ORIGIN_ID"],
						"INPUT_NAME" => $arResult["AGREEMENT_INPUT_NAME"],
						"REPLACE" => array(
							"button_caption" => GetMessage("AUTH_REGISTER"),
							"fields" => array(
								rtrim(GetMessage("AUTH_NAME"), ":"),
								rtrim(GetMessage("AUTH_LAST_NAME"), ":"),
								rtrim(GetMessage("AUTH_LOGIN_MIN"), ":"),
								rtrim(GetMessage("AUTH_PASSWORD_REQ"), ":"),
								rtrim(GetMessage("AUTH_EMAIL"), ":"),
							)
						),
					)
				);*/?>
			</div>
		</div>
		<div class="bx-authform-formgroup-container">
			<input type="submit" class="b-button button_fill button_big b-button_submit b-button_avtoriz" name="Register" value="<?/*=GetMessage("AUTH_REGISTER")*/?>" />
		</div>

		<hr class="bxe-light">

		<div class="bx-authform-description-container">
			<?/*echo $arResult["GROUP_POLICY"]["PASSWORD_REQUIREMENTS"];*/?>
		</div>

		<div class="bx-authform-description-container">
			<span class="bx-authform-starrequired">*</span><?/*=GetMessage("AUTH_REQ")*/?>
		</div>

		<div class="bx-authform-link-container">
			<a class="lost-pass" href="<?/*=$arResult["AUTH_AUTH_URL"]*/?>" rel="nofollow"><b><?/*=GetMessage("AUTH_AUTH")*/?></b></a>
		</div>

	</form>

<script type="text/javascript">
document.bform.USER_NAME.focus();
</script>

<?/*endif*/?>

</noindex>
</div>-->