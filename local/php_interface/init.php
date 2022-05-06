<?php
use Bitrix\Highloadblock\HighloadBlockTable as HLBT;


define("RENT_IBLOCK", 4);
define("FEEDBACK_IBLOCK", 6);
define("ORDER_IBLOCK", 11);
define("STATUS_IBLOCK", 12);
define("EXETENDED_IBLOCK", 15);

define("HLB_WORK_TIME_ID", 2);
define("HLB_PAYMENT_ID", 4);
define("HLB_DELIVERY_ID", 5);
define("HLB_LEASE_ID", 6);

define("DEFAULT_STATUS", 347); // в обработке
define("COMPLETE_STATUS", 348); // завершен
define("CANCEL_STATUS", 349); // отменен

global $USER;
// функцию получения экземпляра класса:
function GetEntityDataClass($HlBlockId)
{
    if (empty($HlBlockId) || $HlBlockId < 1) {
        return false;
    }
    $hlblock = HLBT::getById($HlBlockId)->fetch();
    $entity = HLBT::compileEntity($hlblock);
    $entity_data_class = $entity->getDataClass();
    return $entity_data_class;
}
CModule::IncludeModule('highloadblock');
// рабочее время
$entity_data_class = GetEntityDataClass(HLB_WORK_TIME_ID);
$rsData = $entity_data_class::getList(array(
    'select' => array('*'),
    'filter' => array('UF_ACTIVE' => '1')
));
while ($el = $rsData->fetch()) {
    $worktime = $el;
}

define("BEGIN_WORKTIME", $worktime['UF_TIME_START']);   // начало рабочего дня
define("END_WORKTIME", $worktime['UF_TIME_END']);       // конец рабочего дня

function cutStr($str, $length=50, $postfix='...')
{
    if ( strlen($str) <= $length)
        return $str;

    $temp = substr($str, 0, $length);
    return substr($temp, 0, strrpos($temp, ' ') ) . $postfix;
}

function mbCutString($str, $length, $postfix='...', $encoding='UTF-8')
{
    if (mb_strlen($str, $encoding) <= $length) {
        return $str;
    }

    $tmp = mb_substr($str, 0, $length, $encoding);
    return mb_substr($tmp, 0, mb_strripos($tmp, ' ', 0, $encoding), $encoding) . $postfix;
}

function registerUserByPhone($phone,$email,$name,$address)
{
    if(checkUserByEmail($email) == false){ // если пользователь не зарегистрирован
        $passwordChars = array('abcdefghijklnmopqrstuvwxyz','ABCDEFGHIJKLNMOPQRSTUVWXYZ','0123456789');
        $password = \randString(8, $passwordChars);
//        $password = rand(0, 9).rand(14, 99).rand().rand().rand().rand().rand().rand().rand().rand();
        $user = new CUser;
        $fields = Array(
            "NAME" => $name,
            "LAST_NAME" => "",
            "EMAIL" => $email,
            "LOGIN" => $email, // логин - номер телефона без +
            "LID" => "ru",
            "ACTIVE" => "Y",
            "GROUP_ID" => array(2,5),
            "PASSWORD" => $password,
            "CONFIRM_PASSWORD" => $password,
            "PERSONAL_PHONE" => $phone,
//            'PERSONAL_MOBILE' => $phone,
//            'WORK_PHONE' => $phone,
//            'PHONE_NUMBER' => "+".$phone,
        );
        if(!empty($address))
            $fields["UF_ADDRESS_DELIVERY"] = $address;
        $ID = $user->Add($fields);

        if (intval($ID) > 0):
//            $USER->Authorize($ID);// сразу же авторизуем
            // отправка пароля на почту пользователя
            CEvent::Send("AUTO_REGISTER_USER", SITE_ID, array(
                "EMAIL" => $email,
                "LOGIN" => $email,
                "PASSWORD" => $password,
            ));
            return $ID;
        else:
            return $user->LAST_ERROR;
        endif;

    } else { // если пользователь зарегистрирован
        return checkUserByEmail($email);
    }
}
/**
 * id пользователя по номеру телефона
 * возвращает false если не существует
 * возвращает id если существует
 */
function checkUserByPhone($phone)
{
    $by = "ID";
    $order = "ASC";
    $rsUser = CUser::GetList(($by="ID"), ($order="desc"), array("PERSONAL_PHONE"=>$phone),array());
    $arUser = $rsUser->Fetch();

    if(!empty($arUser['ID']))
    {
        return $arUser['ID']; // пользователь существует
    }
    else
    {
        return false; // пользователь не существует
    }
}

function checkUserByEmail($email){
    $filter = Array("=EMAIL" => $email);
    $sql = CUser::GetList(($by="ID"), ($order="desc"), $filter);
    $arUser = $sql->Fetch();
    if(!empty($arUser['ID']))
    {
        return $arUser['ID']; // пользователь существует
    }
    else
    {
        return false; // пользователь не существует
    }
}

if (file_exists($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/event_handlers.php"))
    require_once($_SERVER["DOCUMENT_ROOT"] . "/local/php_interface/event_handlers.php");
if (file_exists($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/sms.ru.php"))
    require_once($_SERVER["DOCUMENT_ROOT"]."/local/php_interface/include/sms.ru.php");