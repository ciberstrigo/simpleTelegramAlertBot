<?php


namespace TelegramAlertBot;

use Task;

class TaskManager
{
    const SERVICE_URL = 'http://localhost';
    const TASK_FORM_ID = 'eb09efa9-256e-4f30-b524-28e0fc03d31b';
    // path='/api/login' authentication, api token from wiki
    const WIKI_TOKEN = 'a1073044ba5b3b8a7062df58e808c7e4d869c862';

    public static function create(Task $task)
    {
        $parameters = $task->serialize();

        $options = [
            'http' => [
                'header'  =>
                    "Content-type: application/json\r\n" .
                    "x-auth-token: " . self::WIKI_TOKEN . "\r\n"
                ,
                'method'  => 'POST',
                'protocol_version' => 1.1,
                'content' => \json_encode($parameters)
            ]
        ];
        $context = \stream_context_create($options);
        $url = self::SERVICE_URL . '/api/public/forms/' . self::TASK_FORM_ID . '/send';
        $result = \file_get_contents($url, false, $context);

        if (false === $result) {
            throw new \Exception(json_encode($parameters));
        }

        return $result;
    }
}