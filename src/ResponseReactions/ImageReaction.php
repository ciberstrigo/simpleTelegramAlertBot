<?php


namespace TelegramAlertBot\ResponseReactions;


use TelegramAlertBot\Main;
use TelegramAlertBot\Variables;

class ImageReaction implements Interfaces\Reaction
{

    public function isNeedToReact($data): bool
    {
        $photos = $data['message']['document'];
        return (bool) (\count($photos));
    }

    public function react($data)
    {
        $from = $data['message']['chat']['id'];


        Main::$telegram->executeCommand(
            'sendMessage',
            [
                'chat_id' => $from,
                'text' => 'Image detected!' . PHP_EOL . $this->getDocument($data)
            ]
        );
    }


}