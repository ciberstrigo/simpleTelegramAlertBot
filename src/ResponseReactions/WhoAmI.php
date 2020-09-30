<?php


namespace TelegramAlertBot\ResponseReactions;


class WhoAmI implements Interfaces\Reaction
{

    public function isNeedToReact($data): bool
    {
        return (bool) \preg_match('/\/whoami/', $data['message']);
    }

    public function react($data)
    {
        // TODO: Implement react() method.
    }
}