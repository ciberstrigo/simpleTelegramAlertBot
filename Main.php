<?php


namespace TelegramAlertBot;


class Main
{
    public static function main(array $argv = [])
    {
        $telegram = new Telegram();

        self::webHookUpdate($telegram);
        self::wikiAlertUpdate($telegram);

    }

    private static function webHookUpdate(Telegram $telegram) {
        $data = json_decode(file_get_contents('php://input'));

        if (\property_exists($data, 'message')) {
            return;
        }

        $from = $data->{'message'}->{'chat'}->{'id'};
        $text = $data->{'message'}->{'text'};

        switch ($text) {
            default:
                $telegram->executeCommand(
                    'sendMessage',
                    [
                        'text' => \sprintf('Chat id is \'%s\'', $from)
                    ]
                );
                break;
        }
    }

    private static function wikiAlertUpdate(Telegram $telegram)
    {
        $data = json_decode(file_get_contents('php://input'));

        if (
            ! \property_exists($data,'chat_id')
            || ! \property_exists($data, 'text')
        ) {
            return;
        }

        $telegram->executeCommand('sendMessage', [
            'chat_id'   => $data->{'chat_id'},
            'text'      => $data->{'text'},
            'parse_mode' => 'MarkdownV2'
        ]);


    }



}