<?php

declare(strict_types = 1);

namespace Bot;

use Bot\Client\Client;
use Bot\Enums\Messages;
use Bot\Client\HTTPClient;
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

    public function undefined(): void
    {
        echo 'undefined';
    }
}
