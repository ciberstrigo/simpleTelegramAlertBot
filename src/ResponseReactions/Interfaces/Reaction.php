<?php

namespace TelegramAlertBot\ResponseReactions\Interfaces;

interface Reaction
{
    public function isNeedToReact($data): bool;
    public function react($data);
}