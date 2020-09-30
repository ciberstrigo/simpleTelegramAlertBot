<?php


namespace TelegramAlertBot;

use TelegramAlertBot\Entity\Task;
use GuzzleHttp\Client;

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
                    "x-auth-token: " . $_ENV['WIKI_TOKEN'] . "\r\n"
                ,
                'method'  => 'POST',
                'protocol_version' => 1.1,
                'content' => \json_encode($parameters)
            ]
        ];
        $context = \stream_context_create($options);
        $url = $_ENV['WIKI_SERVICE_URL'] . '/api/public/forms/' . $_ENV['WIKI_TASK_FORM_ID'] . '/send';
        $result = \file_get_contents($url, false, $context);

        if (false === $result) {
            throw new \Exception('There is no result from WIKI ANO');
        }

        return $result;
    }

    public static function getTasksByChatId()
    {


        $parameters = [
            'fields' => [
                '8d781459-c7dd-4999-987f-256852f619bb' => [], // Фильтр по пользователям
                '2d9dee0e-e7da-43a5-b078-bdb539321bcd' => [
                    "Новая",
                    "В работе",
                    "На проверке",
                    "Возвращена на доработку",
                    "На обсуждении"
                ], // Статусы задач
            ],
            'type' => '82b87a06-17ff-4d5e-8325-e9d3967eb904',
            'page' => '1',
            'limit' => '25',
            'view_type' => 'table'
        ];

        $options = [
            'http' => [
                'header'  =>
                    "Content-type: application/json\r\n" .
                    "x-auth-token: " . $_ENV['WIKI_TOKEN'] . "\r\n",
                'method'  => 'GET',
                'content' => http_build_query($parameters)
            ]
        ];

        $context = stream_context_create($options);
        $url = $_ENV['WIKI_SERVICE_URL'] . '/api/public/wiki/tasks';
        $result = file_get_contents($url, false, $context);

        if (false === $result) {
            $result = 'no result';
//            throw new \Exception('No result returned again');
        }

        //$result = $result ? $result : 'no result' ;


        return $result;
    }
}