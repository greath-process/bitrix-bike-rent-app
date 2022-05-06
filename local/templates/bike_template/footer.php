<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die(); ?>


<footer class="footer">
    <div class="b-container">
        <div class="footer-top">
            <div class="arend">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/footer_menu_title.php"
                    )
                ); ?>
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer_catalog",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                        "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                        "DELAY" => "N",    // Откладывать выполнение шаблона меню
                        "MAX_LEVEL" => "1",    // Уровень вложенности меню
                        "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                        "MENU_CACHE_TYPE" => "N",    // Тип кеширования
                        "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                        "ROOT_MENU_TYPE" => "bottom_section",    // Тип меню для первого уровня
                        "USE_EXT" => "Y",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                    ),
                    false
                ); ?>

            </div>
            <div class="footer-menu">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:menu",
                    "footer_menu",
                    array(
                        "ALLOW_MULTI_SELECT" => "N",    // Разрешить несколько активных пунктов одновременно
                        "CHILD_MENU_TYPE" => "left",    // Тип меню для остальных уровней
                        "DELAY" => "N",    // Откладывать выполнение шаблона меню
                        "MAX_LEVEL" => "1",    // Уровень вложенности меню
                        "MENU_CACHE_GET_VARS" => array(    // Значимые переменные запроса
                            0 => "",
                        ),
                        "MENU_CACHE_TIME" => "3600",    // Время кеширования (сек.)
                        "MENU_CACHE_TYPE" => "A",    // Тип кеширования
                        "MENU_CACHE_USE_GROUPS" => "Y",    // Учитывать права доступа
                        "ROOT_MENU_TYPE" => "bottom",    // Тип меню для первого уровня
                        "USE_EXT" => "N",    // Подключать файлы с именами вида .тип_меню.menu_ext.php
                    ),
                    false
                ); ?>
            </div>
        </div>
        <div class="footer-bottom">
            <div class="footer-bottom__copir">
                <? $APPLICATION->IncludeComponent(
                    "bitrix:main.include",
                    "",
                    array(
                        "AREA_FILE_SHOW" => "file",
                        "AREA_FILE_SUFFIX" => "inc",
                        "EDIT_TEMPLATE" => "",
                        "PATH" => "/include/copyright.php"
                    )
                ); ?>
            </div>
            <? $APPLICATION->IncludeComponent(
                "bitrix:main.include",
                "",
                array(
                    "AREA_FILE_SHOW" => "file",
                    "AREA_FILE_SUFFIX" => "inc",
                    "EDIT_TEMPLATE" => "",
                    "PATH" => "/include/privacy.php"
                )
            ); ?>
            <div class="footer-socials">
                <div class="socials">
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/facebook.php"
                        )
                    ); ?>
                    <? $APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        "",
                        array(
                            "AREA_FILE_SHOW" => "file",
                            "AREA_FILE_SUFFIX" => "inc",
                            "EDIT_TEMPLATE" => "",
                            "PATH" => "/include/instagram.php"
                        )
                    ); ?>
                </div>
            </div>
        </div>
    </div>
</footer>

<div style="display: none" id="button_check_dates" data-id="#popup-freedate"></div>

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

<a href="#popup-submit" style="display: none;" id="popup-success" name="modal" class="b-button button_fill button_big b-button_prodlen">Form result</a>
<!------------------Заявка принята ---------------!-->
<div id="popup-submit" class="popup-window">
    <a href="#" class="popup-close" /><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0)">
            <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
    </svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full">Your application has been successfully sent.</div>
        <div class="b-button_zakaz"><a class="b-button button_fill button_big" href="/">To homepage</a></div>
    </div>
</div>
<a href="#popup-errors" style="display: none;" id="popup-error" name="modal" class="b-button button_fill button_big b-button_prodlen">Form result</a>
<!------------------ Ошибки ---------------!-->
<div id="popup-errors" class="popup-window">
    <a href="#" class="popup-close" /><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
        <g clip-path="url(#clip0)">
            <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
        </g>
    </svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full" id="error_message">Error</div>
        <div class="b-button_zakaz"><a class="b-button button_fill button_big" href="/">To homepage</a></div>
    </div>
</div>

<!------------------Всплывающее отмена заказа---------------!-->
<div id="popup-cancel" class="popup-window">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full">Are you sure you want to delete the order? Please note this action cannot be undone.</div>
        <div class="b-button_zakaz"><a id="cancel_order" data-id="" class="b-button button_fill button_big">To cancel an order</a></div>
        <div class="b-button_zakaz"><a id="popup-close" class="b-button button_space button_big">Leave it as is</a></div>
    </div>
</div>

<a href="#popup-canceled" style="display: none;" id="canceled_order" name="modal">Order cancelled</a>
<!------------------Всплывающее Заказ отменен.---------------!-->
<div id="popup-canceled" class="popup-window">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full center">Order cancelled.</div>
        <div class="button-canceled">
            <div class="button-canceled_zakaz">
                <a class="b-button button_fill button_big" href="/personal/">Back to personal account</a>
            </div>
            <div class="button-canceled_zakaz">
                <a class="b-button button_space button_big" href="/">To homepage</a>
            </div>
        </div>
    </div>
</div>
<a href="#popup-admin-canceled" style="display: none;" id="admin_canceled_order" name="modal">Order cancelled.</a>
<!------------------Всплывающее Заказ отменен админка .---------------!-->
<div id="popup-admin-canceled" class="popup-window">
    <a href="#" class="popup-close"><svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg></a>
    <div class="popup-content">
        <div class="popup-title popup-title_full center">Order cancelled.</div>
        <div class="b-button_zakaz">
            <a id="popup-reload" class="b-button button_fill button_big">OK</a>
        </div>
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

<!------------------Всплывающая модалка отправка смс---------------!-->
<div id="popup-sms-send" class="popup-window" style="left: 25%;top: 25%;">
    <a href="#" class="popup-close">
        <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
            <g clip-path="url(#clip0)">
                <path d="M20.6377 1.54594L1.54585 20.6378M1.54585 1.54594L20.6377 20.6378" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
            </g>
        </svg>
    </a>
    <div class="popup-content">
        <form class="popup-title popup-title_full" style="text-align: center;" id="num_check">
            <input type="hidden" id="text_sms" value="Your verification code: ">
            The verification code has been sent via SMS to your number.<br>Enter it below<br><br>
            <input type="number" name="code" class="input" id="num_code"><br><br>
            <button type="submit" class="b-button button_fill button_big b-button_check">Confirm</button><br>
            <span id="error_check_sms" style="color:red;display:none">The code was entered incorrectly</span>
        </form>
    </div>
</div>

<div class="popup-mask"></div>
<?include_once($_SERVER['DOCUMENT_ROOT'].'/include/counters.php')?>
</body>

</html>