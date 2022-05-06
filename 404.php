<?
include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/include/urlrewrite.php');

CHTTP::SetStatus("404 Not Found");
@define("ERROR_404", "Y");
define("HIDE_SIDEBAR", true);

require($_SERVER["DOCUMENT_ROOT"] . "/bitrix/header.php");

$APPLICATION->SetTitle("Страница не найдена"); ?>
<div class="error-page">
    <div class="error-page__title">404</div>
    <div class="error-page__desc">The page does not exist or has not created yet</div>
    <a class="b-button button_fill button_big button_normal error-page__button" href="/">Back to main page</a>
</div>
<!------------------Всплывающее Обратная связь---------------!-->
<div id="popup-callback" class="popup-window">
    <a href="#" class="popup-close" /><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0)">
            <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
    </svg></a>
    <div class="popup-content">
        <? $APPLICATION->IncludeComponent(
            "bitrix:main.include",
            "",
            array(
                "AREA_FILE_SHOW" => "file",
                "AREA_FILE_SUFFIX" => "inc",
                "EDIT_TEMPLATE" => "",
                "PATH" => "/include/feedback_form_popup.php"
            )
        ); ?>
    </div>
</div>

<a href="#popup-submit" style="display: none;" id="popup-success" name="modal" class="b-button button_fill button_big b-button_prodlen">Результат формы</a>
<!------------------Заявка принята ---------------!-->
<div id="popup-submit" class="popup-window">
    <a href="#" class="popup-close" /><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0)">
            <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
    </svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full">Your application has been successfully sent.</div>
        <div class="b-button_zakaz"><a class="b-button button_fill button_big" href="/">На главную страницу</a></div>
    </div>
</div>
<!------------------Всплывающее Авторизация/Регистрация---------------!-->
<div id="popup-lk" class="popup-window">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg></a>
    <div class="popup-content">
        <div class="pop-login">
            <a class="pop-login__link pop-login_active" href="#avtoriz">Log in</a>
            <a class="pop-login__link" href="#registr">Registration</a>
        </div>
        <div id="avtoriz" class="login-tab" style="display: block;">
            <form id="auth-form">
                <div class="sub-info">
                    <div class="sub-info__text">Login</div>
                    <div class="form-line">
                        <input type="text" class="input" name="USER_EMAIL" required placeholder="E-mail" />
                    </div>
                </div>
                <div class="sub-info">
                    <div class="sub-info__text">Password</div>
                    <div class="form-line form-line_pass">
                        <input type="password" class="input" name="USER_PASSWORD" required placeholder="Password" />
                        <a class="password-control" href="#"></a>
                    </div>
                </div>
                <small class="auth-password-text"></small>
                <input type="submit" class="b-button button_fill button_big b-button_submit b-button_avtoriz" value="Sign in" />
                <div class="center">
                    <a class="lost-pass" name="modal" href="#popup-forgot">Forgot your password?</a>
                </div>
            </form>
        </div>
        <div id="registr" class="login-tab register-tab">
            <form name="regform" id="registration-form">
                <small class="register-error-text"></small>
                <div class="sub-info">
                    <div class="sub-info__text">Name*</div>
                    <div class="form-line"><input type="text" class="input" name="USER_NAME" required placeholder="Name" /></div>
                </div>
                <div class="sub-info">
                    <div class="sub-info__text">Phone number*</div>
                    <div class="form-line"><input type="text" class="input masc-phone" name="PERSONAL_PHONE" required placeholder="Phone number" /></div>
                </div>
                <div class="sub-info sub-info_lk">
                    <div class="sub-info__text">E-mail*</div>
                    <div class="form-line"><input type="email" class="input" name="EMAIL" required placeholder="E-mail" /></div>
                </div>
                <div class="sub-info sub-info_lk">
                    <div class="sub-info__text">Password*</div>
                    <div class="form-line form-line_pass">
                        <input type="password" required class="input" name="PASSWORD" placeholder="Password" />
                        <a class="password-control" href="#"></a>
                    </div>
                </div>
                <div class="form-line form-line_lk">
                    <input type="checkbox" class="checkbox" id="accept2" checked>
                    <label class="label-check label-check_accept" for="accept2">
                        <span class="accept32"><svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="32" height="32" rx="10" fill="currentcolor" />
                                <path d="M12 16L14.9995 19L19.9995 14" stroke-width="2" stroke="white" stroke-linecap="round" stroke-linejoin="round" />
                            </svg></span>
                        Сonsent to processing of personal data
                    </label>
                </div>
                <input type="submit" class="b-button button_fill button_big b-button_submit b-button_registr" value="Register now" />
                <div class="center">Already have an account? <a class="lost-pass" name="avtoriz" href="#avtoriz">Sign in</a></div>
            </form>
        </div>
    </div>
</div>

<!------------------Всплывающее Восстановление пароля ---------------!-->
<div id="popup-forgot" class="popup-window">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg></a>
    <div class="popup-content">
        <div class="popup-title">Password recovery</div>
        <form id="reset-form">
            <div class="sub-info">
                <div class="sub-info__text">Login</div>
                <div class="form-line">
                    <input type="email" class="input" name="USER_EMAIL" required placeholder="E-mail" />
                </div>
            </div>
            <small class="reset-password-text"></small>
            <input type="submit" class="b-button button_fill button_big b-button_submit b-button_avtoriz" value="Send" />
            <div class="center">
                <a class="lost-pass" name="modal" href="#popup-lk">I already have an account</a>
            </div>
        </form>
    </div>
</div>


<div class="popup-mask"></div>
<? //require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");
?>