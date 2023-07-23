<?php

namespace Bot\Client;

use Bot\Enums\Messages;

interface HTTPClient
{
    public function send(string $method, int $chatID, Messages|string $message): void;
}
