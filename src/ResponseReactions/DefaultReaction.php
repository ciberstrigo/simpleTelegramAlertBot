<?php

namespace TelegramAlertBot\ResponseReactions;

use TelegramAlertBot\Main;
use TelegramAlertBot\ResponseReactions\Interfaces\Reaction;

class DefaultReaction implements Reaction
{

    public function isNeedToReact($data): bool
    {
        return true;
    }

    public function react($data)
    {
        $from = $data['message']['chat']['id'];

        // Ignore if message is not from user
        if ( ( (int) $from ) < 0) {
            return;
        }

        $text = $data['message']['text'];

        Main::$telegram->executeCommand(
            'sendMessage',
            [
                'chat_id' => $from,
                'text' => \sprintf('Chat id is \'%s\'', $from)
            ]
        );
    }
}