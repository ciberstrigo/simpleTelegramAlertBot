<?php


namespace TelegramAlertBot\Helpers;


use TelegramAlertBot\Main;
use TelegramAlertBot\Variables;

class TelegramAttachments
{
    public static function getImagesLinks($data): array
    {
        if ( ! \array_key_exists('photo', $data['message'])) {
            return [];
        }

        $photos = $data['message']['photo'];

        $filePatches = [];
        foreach ($photos as $photo) {
            $filePatches[] =
                'https://api.telegram.org/file/bot'.Variables::BOT_TOKEN .'/'.
                json_decode(Main::$telegram->executeCommand(
                    'getFile',
                    [
                        'file_id' => $photo['file_id']
                    ]
                ), true)['result']['file_path'];
        }
        return $filePatches;
    }

    public static function getVideoLink($data): array
    {
        if ( ! \array_key_exists('video', $data['message'])) {
            return [];
        }

        $video = $data['message']['video'];
        $filePatch =
            'https://api.telegram.org/file/bot'.Variables::BOT_TOKEN .'/'.
            json_decode(Main::$telegram->executeCommand(
                'getFile',
                [
                    'file_id' => $video['file_id']
                ]
            ), true)['result']['file_path'];
        return [$filePatch];
    }

    public static function getDocumentLink($data): array
    {
        if ( ! \array_key_exists('document', $data['message'])) {
            return [];
        }

        $document = $data['message']['document'];
        $filePatch =
            'https://api.telegram.org/file/bot'.Variables::BOT_TOKEN .'/'.
            json_decode(Main::$telegram->executeCommand(
                'getFile',
                [
                    'file_id' => $document['file_id']
                ]
            ), true)['result']['file_path'];
        return [$filePatch];

    }
}