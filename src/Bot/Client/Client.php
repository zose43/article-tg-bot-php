<?php

declare(strict_types = 1);

namespace Bot\Client;

use Bot\Exceptions\BotInitException;

final class Client implements HTTPClient
{
    /**
     * @throws BotInitException
     */
    public function __construct(public string $token, public string $basePath, public array $options = [])
    {
        if (empty($this->token) || empty($this->basePath)) {
            throw new BotInitException();
        }
    }
}
