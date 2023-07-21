<?php

declare(strict_types = 1);

namespace Bot\Components;

use Monolog\Level;
use Monolog\Logger as MonologLogger;
use Monolog\Handler\StreamHandler;
use Monolog\Formatter\LineFormatter;

final class Logger
{
    public const PRODUCER = 'bot_producer';
    public const CONSUMER = 'bot_consumer';

    private static array $loggers;

    public static function getLogger(string $channel = 'bot', string $filename = 'bot'): MonologLogger
    {
        if (empty(self::$loggers[$channel])) {
            return self::newLogger($channel, $filename);
        }
        return self::$loggers[$channel];
    }

    private static function newLogger(string $name, string $filename): MonologLogger
    {
        $logger = new MonologLogger($name);
        $streamHandler = new StreamHandler("xxx/logs/$filename.log", Level::Info);
        $formatter = new LineFormatter(dateFormat: 'Y-m-d H:m:s', ignoreEmptyContextAndExtra: true);
        $streamHandler->setFormatter($formatter);
        $logger->pushHandler($streamHandler);

        self::$loggers[$name] = $logger;
        return $logger;
    }
}
