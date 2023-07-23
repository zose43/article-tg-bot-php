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
use Bot\Exceptions\NoSavedMessageException;

final class Command
{
    public const START = '/start';
    public const HELP = '/help';
    public const RANDOM = '/rnd';

    public function start(Payload $payload, HTTPClient $client): void
    {
        $client->send(
            Client::SEND_MESSAGE,
            $payload->getMessage()->chatID,
            Messages::MsgStart);
    }

    public function help(Payload $payload, HTTPClient $client): void
    {
        $client->send(
            Client::SEND_MESSAGE,
            $payload->getMessage()->chatID,
            Messages::MsgHelp);
    }

    public function undefined(Payload $payload, HTTPClient $client): void
    {
        $client->send(
            Client::SEND_MESSAGE,
            $payload->getMessage()->chatID,
            Messages::UnknownCmd);
        Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->info("can't recognize command", [
            'cmd' => $payload->getMessage()->url
        ]);
    }

    public function savePage(Storage $storage, Payload $payload, HTTPClient $client): void
    {
        try {
            $double = $storage->isExist($payload);
            if ($double) {
                $client->send(
                    Client::SEND_MESSAGE,
                    $payload->getMessage()->chatID,
                    Messages::MsgAlreadyExist
                );
            } else {
                $storage->save($payload);
                $client->send(
                    Client::SEND_MESSAGE,
                    $payload->getMessage()->chatID,
                    Messages::MsgSaved
                );
            }
        } catch (Exception $e) {
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }

    public function random(Storage $storage, Payload $payload, HTTPClient $client): void
    {
        try {
            $stuff = $storage->pickRandom($payload);
            if (is_null($stuff)) {
                $client->send(
                    Client::SEND_MESSAGE,
                    $payload->getMessage()->chatID,
                    Messages::MsgNoSavedPages
                );
                throw new NoSavedMessageException('no one article find');
            }
            $client->send(
                Client::SEND_MESSAGE,
                $payload->getMessage()->chatID,
                $stuff->getUrl()
            );
        } catch (Exception $e) {
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
            ]);
        }
    }
}
