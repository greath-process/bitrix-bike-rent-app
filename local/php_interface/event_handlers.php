<?php

AddEventHandler("main", "OnBeforeUserRegister", array("MyClass", "OnBeforeUserRegisterHandler"));
AddEventHandler("main", "OnBeforeUserUpdate", array("MyClass", "OnBeforeUserUpdateHandler"));

class MyClass
{
    function OnBeforeUserRegisterHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
    }
    function OnBeforeUserUpdateHandler(&$arFields)
    {
        $arFields["LOGIN"] = $arFields["EMAIL"];
    }
}


$eventManager = \Bitrix\Main\EventManager::getInstance();
$eventManager->addEventHandler(
    "main",
    "OnBeforeEventAdd",
    [
        "NotificationHandler",
        "mailEventHandle"
    ]
);

class NotificationHandler
{
    // для telegram api при установленном parseMode:MarkdownV2 необходимо экранировать символы "." и "-"
    static string $newOrderMsgTemplate =
    "Новый заказ № %d от %s принят.\n\n" .
        "Время заказа: %s - %s.\n" .
        "Подробнее в кабинете оператора http://bikepark.ae/personal/admin/";

    static string $botToken = "2127186731:AAEoV6sszxy1woV916Khjm2H2J5ceerebO4";
    static string $chatId = "-1001703423555";

    public function mailEventHandle(&$event, &$lid, &$fields)
    {
        if ($event == "ORDER_FORM") {
            self::sendAdminMessage($fields);
        }
    }

    public static function sendAdminMessage($fields)
    {
        $message = self::getMessage($fields);
        if ($message) {
            $body = array(
                "chat_id" => self::$chatId,
                "text" => $message,
            );
            $url = self::getUrl();
            self::sendRequestToBot($body, $url);
        }
    }

    public static function getMessage($fields)
    {
        return sprintf(self::$newOrderMsgTemplate, $fields['ORDER_ID'], $fields['ORDER_DATE'], $fields['DATE_START'], $fields['DATE_END']);
    }

    private static function getUrl()
    {
        $botToken = self::$botToken;
        return "https://api.telegram.org/bot$botToken/sendMessage";
    }

    public static function sendRequestToBot($body, $url)
    {
        $httpClient = new \Bitrix\Main\Web\HttpClient();
        $response = $httpClient->post(
            $url,
            $body,
            false
        );
    }
}
