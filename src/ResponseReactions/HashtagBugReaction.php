<?php

namespace TelegramAlertBot\ResponseReactions;

use TelegramAlertBot\Entity\Task;
use TelegramAlertBot\Helpers\TelegramAttachments;
use TelegramAlertBot\Helpers\WikiFileLoader;
use TelegramAlertBot\Main;
use TelegramAlertBot\ResponseReactions\Interfaces\Reaction;
use TelegramAlertBot\Telegram;

class HashtagBugReaction implements Reaction
{
    const DESCRIPTION_LENGTH = 5;

    public function isNeedToReact($data): bool
    {
        $text = isset($data['message']['text']) ? $data['message']['text'] : '';
        $caption = isset($data['message']['caption']) ? $data['message']['caption'] : '';

        $messageText = $text . $caption;
        return (bool) \preg_match('/#bug/', $messageText);
    }

    public function react($data)
    {
        $text = isset($data['message']['text']) ? $data['message']['text'] : '';
        $caption = isset($data['message']['caption']) ? $data['message']['caption'] : '';

        $text = \str_replace('#bug', '', $text . $caption);

        if (\array_key_exists('reply_to_message', $data['message'])) {
            $text .= $data['message']['reply_to_message']['text'];
        }

        $titleAndText = \explode(PHP_EOL, $text);

        if (1 === \count($titleAndText)) {
            $pieces = explode(" ", $text);
            $title = "[BUG] " . implode(" ", array_splice($pieces, 0, $_ENV['TASK_DESCRIPTION_LENGTH']));
            $description = $text;
        } else {
            $title = "[BUG] " . $titleAndText[0];
            $description = implode(" ", array_splice($titleAndText, 1, \count($titleAndText)));
        }


        $task = new Task();
        $task->setDescription($description);
        $task->setTask($title);
        $task->setRegion('eeeada6b-9ed9-48cc-bc48-8a2c544ca142');
        $task->setStatus('Новая');

// @todo сделать загрузку файлов

//        $files = \array_merge(
//            TelegramAttachments::getImagesLinks($data),
//            TelegramAttachments::getVideoLink($data),
//            TelegramAttachments::getDocumentLink($data)
//        );
//
//        $filesNextcloudLinks = WikiFileLoader::loadArray($files);
//        $task->setFiles($filesNextcloudLinks);


        if (false === $task->isAllRequiredSet()) {
            throw new \Exception('Not every required parameters was set!');
        }

        try {
            $result = \TelegramAlertBot\TaskManager::create($task);
        } catch (\Exception $e) {
            throw $e;
        }

        $result = json_decode($result, true);

        $from = $data['message']['chat']['id'];
        $messageId = $data['message']['message_id'];
        $taskUrl = $_ENV['WIKI_SERVICE_URL'] . $result['data']['redirectUrl'];

        Main::$telegram->executeCommand(
            'sendMessage',
            [
                'chat_id' => $from,
                'text' =>
                    '🐞<b>Баг зафиксирован.</b>' . PHP_EOL .
                    '<b>Ссылка:</b> <a href="' . $taskUrl . '">' . $taskUrl . '</a>' . PHP_EOL
                ,
                'parse_mode' => 'HTML',
                'reply_to_message_id' => $messageId
            ]
        );

    }
}