<?php


namespace TelegramAlertBot\ResponseReactions;


use TelegramAlertBot\Main;
use TelegramAlertBot\TaskManager;

class ShowMyTasks implements Interfaces\Reaction
{

    public function isNeedToReact($data): bool
    {
        $text = isset($data['message']['text']) ? $data['message']['text'] : '';
        $caption = isset($data['message']['caption']) ? $data['message']['caption'] : '';
        $messageText = $text . $caption;

        return (bool) \preg_match('/\/tasks/', $messageText);
    }

    public function react($data)
    {
        $keyboard = [
            'inline_keyboard' => [
                [
                    ['text' => 'forward me to groups', 'callback_data' => 'someString']
                ]
            ]
        ];
        $encodedKeyboard = json_encode($keyboard);

        $from = $data['message']['chat']['id'];

        $text = TaskManager::getTasksByChatId();

        Main::$telegram->executeCommand(
            'sendMessage',
            [
                'chat_id' => $from,
                'text' => $text,
                'parse_mode' => 'HTML',
                'reply_markup' => $encodedKeyboard
            ]
        );

    }
}