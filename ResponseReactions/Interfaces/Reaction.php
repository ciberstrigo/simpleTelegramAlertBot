<?php


interface Reaction
{
    public function isNeedToReact($data): bool;
    public function react($data);
}