<?php


namespace TelegramAlertBot\Helpers;

use GuzzleHttp\Client;

class WikiFileLoader
{
    public static function load(string $link)
    {
        $filename = \basename($link);

        $file = file_get_contents($link);


        $client = new Client([
            'base_uri' => 'http://localhost',
            'timeout' => 2.0
        ]);

        $response =
            $client->request('POST', '/api/files/upload', [
                'multipart' => [
                    [
                        'name' => 'filename',
                        'contents' => $file
                    ],
                    [
                        'name'     => 'name',
                        'contents' => 'Example name'
                    ]
                ]
            ]);

        $result = json_decode($response->getBody(), true);

        return $result['data']['path'];

    }

    public static function loadArray(array $links)
    {
        $result = [];
        foreach ($links as $link) {
            $result[] = self::load($link);
        }
        return $result;
    }
}