<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/modules/main/include/prolog_before.php");
use Bitrix\Main\Application;
$request = Application::getInstance()->getContext()->getRequest();
$numer = $request->get("numer");
$text = $request->get("text");
$step = $request->get("step");
$code = $request->get("code");

if($numer && $step == 'send')
{
    $dbUser = \Bitrix\Main\UserTable::getList(array(
        'select' => array('ID'),
        'filter' => array('PERSONAL_PHONE' => $numer)
    ));
    if (!$arUser = $dbUser->fetch())
    {
        $smsru = new SMSRU();
        $data = new stdClass();
        $sms_code = randString(8, array("0123456789"));
        $data->to = preg_replace("/[^0-9]/", '', $numer);
        $data->text = $sms_code; // Текст сообщения $text.
        // $data->from = ''; // Если у вас уже одобрен буквенный отправитель, его можно указать здесь, в противном случае будет использоваться ваш отправитель по умолчанию
        //$data->test = 1; // Позволяет выполнить запрос в тестовом режиме без реальной отправки сообщения
        $sms = $smsru->send_one($data); // Отправка сообщения и возврат данных в переменную
        if ($sms->status == "OK") {
            echo "true";  echo "ID сообщения: $sms->sms_id. "; echo "Ваш новый баланс: $sms->balance"; echo "Текст сообщения: ".$text.$sms_code;
            global $_SESSION; $_SESSION['SMS_CODE'] = $sms_code;
        } else {
            echo "false"; echo "Код ошибки: $sms->status_code. ";echo "Текст ошибки: $sms->status_text.";
        }
    }
}
if($numer && $step == 'check' && $code)
{
    global $_SESSION, $USER;
    if($_SESSION['SMS_CODE'] == $code)
    {
        //если авторизован
        if ($USER->IsAuthorized()) 
        {
            // обновляем поле телефона
            $id = $USER->GetID();
            $user = new CUser;
            $fields = Array(
                "PERSONAL_PHONE" => $numer,
            );
            $user->Update($id, $fields);
            echo "true";
        }
        else // если не авторизован
        {
            $type = $request->get("type");
            if($type == 'auth')
            {
                echo "true";
            }
            else
            {
                // регистрируем и прописываем пароль кодом из смс
                $name = $request->get("USER_NAME");
                $email = $request->get("EMAIL");
                $user = new CUser;
                $fields = Array(
                    "NAME" => $name,
                    "EMAIL" => $email,
                    "LOGIN" => $email,
                    "LID" => "ru",
                    "ACTIVE" => "Y",
                    "GROUP_ID" => array(3,4,5),
                    "PASSWORD" => $code,
                    "CONFIRM_PASSWORD" => $code,
                    "PERSONAL_PHONE" => $numer,
                );
                $userID = $user->Add($fields);
                if (intval($userID) > 0)
                {
                    $USER->Authorize($userID);
                    echo "true";
                }
            }
        }
    }
    else
    {
        echo "wrong";
    }
}