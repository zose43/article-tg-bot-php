<?php

declare(strict_types = 1);

namespace Bot;

use Bot\Client\HTTPClient;
use Bot\Models\Dto\Payload;

final class Command
{
    public const START = '/start';
    public const HELP = '/help';

    public function start(Payload $payload, HTTPClient $client): void
    {
//        file_put_contents('xxx/webhook/' . uniqid('tg_bot', true), 'success');
    }

    public function help(): void
    {
        echo 'help';
    }

    public function undefined(): void
    {
        echo 'undefined';
    }
}
