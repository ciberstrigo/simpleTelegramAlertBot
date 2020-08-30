<?php


namespace TelegramAlertBot;


class Telegram
{
    CONST TELEGRAM_API = 'https://api.telegram.org/bot';

    public function executeCommand($method, array $parameters)
    {
        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($parameters)
            ]
        ];
        $context = stream_context_create($options);
        $url = self::TELEGRAM_API.Variables::BOT_TOKEN.'/'.$method;
        $result = file_get_contents($url, false, $context);

        return $result;
    }
}

