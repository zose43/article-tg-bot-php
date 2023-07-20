<?php

declare(strict_types = 1);

namespace Bot\Exceptions;

use Throwable;
use InvalidArgumentException;

final class BotInitException extends InvalidArgumentException
{
    public function __construct(string $message = "", int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->message = 'Telegram bot token or API endpoint are empty';
    }
}
