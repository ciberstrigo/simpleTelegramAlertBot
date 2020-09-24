<?php


use TelegramAlertBot\Main;
use TelegramAlertBot\Telegram;

class HashtagBugReaction implements Reaction
{
    const DESCRIPTION_LENGTH = 5;

    public function isNeedToReact($data): bool
    {
        $messageText = $data['message']['text'];
        return (bool) \preg_match('/#bug/', $messageText);
    }

    public function react($data)
    {
        $text = \str_replace('#bug', '', $data['message']['text']);

        if (\array_key_exists('reply_to_message', $data['message'])) {
            $text .= $data['message']['reply_to_message']['text'];
        }

        $titleAndText = \explode(PHP_EOL, $text);

        if (1 === \count($titleAndText)) {
            $pieces = explode(" ", $text);
            $title = "[BUG] " . implode(" ", array_splice($pieces, 0, self::DESCRIPTION_LENGTH));
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

        if (false === $task->isAllRequiredSet()) {
            throw new \Exception('Not every required parameters was set!');
        }

        try {
            $result = \TelegramAlertBot\TaskManager::create($task);
        } catch (Exception $e) {
            throw $e;
        }

        $result = json_decode($result, true);

        $from = $data['message']['chat']['id'];
        $messageId = $data['message']['message_id'];
        $taskUrl = \TelegramAlertBot\TaskManager::SERVICE_URL . $result['data']['redirectUrl'];

        Main::$telegram->executeCommand(
            'sendMessage',
            [
                'chat_id' => $from,
                'text' =>
                    '🐞<b>Баг зафиксирован.</b>' . PHP_EOL .
                    '<b>Ссылка:</b> <a href="' . $taskUrl . '">' . $taskUrl . '</a>' . PHP_EOL
//                    '<b>json: </b>' . json_encode($data)
                ,
                'parse_mode' => 'HTML',
                'reply_to_message_id' => $messageId
            ]
        );

    }
}