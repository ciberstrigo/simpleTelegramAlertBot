<?php


abstract class Entity
{
    abstract public function serialize(): array;

    abstract public function isAllRequiredSet(): bool;
}