<?php


namespace TelegramAlertBot;


class ResponseReactionsCollection
{
    private static $instances = [];

    protected function __construct() { }

    protected function __clone() { }

    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    public static function getInstance(): ResponseReactionsCollection
    {
        $cls = static::class;
        if (!isset(self::$instances[$cls])) {
            self::$instances[$cls] = new static();
            // Добавляем действия
            self::$instances[$cls]->addReactions();
        }

        return self::$instances[$cls];
    }

    /**
     * @var \Reaction[]
     */
    private $reactionsCollection;

    /**
     * @var \Reaction
     */
    private $defaultReaction;

    private function addReactions()
    {
        $this->reactionsCollection[] = new \HashtagBugReaction();
        $this->reactionsCollection[] = new \HashtagCurrentRequestReaction();
        $this->defaultReaction = new \DefaultReaction();
    }

    public function getReactions()
    {
        return $this->reactionsCollection;
    }

    public function getDefaultReaction()
    {
        return $this->defaultReaction;
    }


}