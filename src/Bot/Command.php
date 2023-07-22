<?php

declare(strict_types = 1);

namespace Bot;

use Exception;
use Bot\Client\Client;
use Bot\Enums\Messages;
use Bot\Storage\Storage;
use Bot\Client\HTTPClient;
use Bot\Components\Logger;
use Bot\Models\Dto\Payload;

final class Command
{
    public const START = '/start';
    public const HELP = '/help';

    public function start(Payload $payload, HTTPClient $client): void
    {
        $client->send(
            Client::SEND_MESSAGE,
            $payload->message->chatID,
            Messages::MsgStart);
    }

    public function help(Payload $payload, HTTPClient $client): void
    {
        $client->send(
            Client::SEND_MESSAGE,
            $payload->message->chatID,
            Messages::MsgHelp);
    }

    public function undefined(string $text): void
    {
        Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->info("can't recognize command", [
            'cmd' => $text
        ]);
    }

    public function savePage(Storage $storage, Payload $payload): void
    {
        try {
            $storage->save($payload);
        } catch (Exception $e) {
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
