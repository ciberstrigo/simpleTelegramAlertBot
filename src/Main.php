<?php


namespace TelegramAlertBot;


use Exception;
use TelegramAlertBot\ResponseReactions\Interfaces\Reaction;

class Main
{
    /**
     * @var Telegram
     */
    public static $telegram;


    public static function main()
    {
        self::$telegram = new Telegram();
        $content = json_decode(file_get_contents('php://input'), true);


        $isWebhook = self::webHookUpdate($content);
        $isAlert = self::wikiAlertUpdate($content);


        if ( ! $isWebhook && ! $isAlert ) {
            echo('this is telegram bot server');
        }

    }

    private static function webHookUpdate($data) {
        if (null === $data) {
            return false;
        }
        if ( ! \array_key_exists('message', $data)) {
            return false;
        }

        $reactions = ResponseReactionsCollection::getInstance()->getReactions();
        $defaultReaction = ResponseReactionsCollection::getInstance()->getDefaultReaction();


//        self::$telegram->executeCommand(
//            'sendMessage',
//            [
//                'chat_id' => $data['message']['chat']['id'],
//                'text' => '{EXCEPTION} ' . PHP_EOL . 'Message: ' . json_encode($data)
//            ]
//        ); die;

        try {
            $reactionProcessed = false;

            foreach ($reactions as $reaction) {
                if ($reaction->isNeedToReact($data)) {
                    $reaction->react($data);
                    $reactionProcessed = true;
                    break;
                }
            }

            if (false === $reactionProcessed) {
                if ($defaultReaction->isNeedToReact($data)) {
                    $defaultReaction->react($data);
                }
            }
        } catch (\Exception $exception) {
            self::$telegram->executeCommand(
                'sendMessage',
                [
                    'chat_id' => $data['message']['chat']['id'],
                    'text' => '{EXCEPTION} ' . PHP_EOL . 'Message: ' . $exception->getMessage() . PHP_EOL . 'File: ' . $exception->getFile() . PHP_EOL . 'On line: ' . $exception->getLine()
                ]
            );
            throw $exception;
        }

        return true;
    }

    private static function wikiAlertUpdate($data)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (null === $data) {
            return null;
        }
        if (
            ! \array_key_exists('chat_id', $data)
            || ! \array_key_exists('text', $data)
        ) {
            return;
        }
        self::$telegram->executeCommand('sendMessage', [
            'chat_id'   => $data['chat_id'],
            'text'      => \str_replace('&nbsp;', ' ', $data['text']),
            'parse_mode' => 'MarkdownV2'
        ]);
    }

}

