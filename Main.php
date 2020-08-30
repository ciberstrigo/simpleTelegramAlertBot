<?php


namespace TelegramAlertBot;


class Main
{
    public static function main()
    {
        $telegram = new Telegram();
        $content = json_decode(file_get_contents('php://input'), true);
        self::webHookUpdate($content, $telegram);
        self::wikiAlertUpdate($content, $telegram);

    }

    private static function webHookUpdate(array $data, Telegram $telegram) {
        if (null === $data) {
            return;
        }
        if ( ! \array_key_exists('message', $data)) {
            return;
        }
        $from = $data['message']['chat']['id'];
        $text = $data['message']['text'];

        switch ($text) {
            default:
                $telegram->executeCommand(
                    'sendMessage',
                    [
                        'chat_id' => $from,
                        'text' => \sprintf('Chat id is \'%s\'', $from)
                    ]
                );
                break;
        }
    }

    private static function wikiAlertUpdate(array $data, Telegram $telegram)
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
        $telegram->executeCommand('sendMessage', [
            'chat_id'   => $data['chat_id'],
            'text'      => $data['text'],
            'parse_mode' => 'MarkdownV2'
        ]);
    }

}

