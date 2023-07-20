<?php

declare(strict_types = 1);

namespace Bot\Components;

use RedisException;

final class Queue
{
    public const PAYLOAD = 'bot_payload';

    public static function push(mixed $payload): void
    {
        try {
            self::getRedis()->rPush(self::PAYLOAD, $payload);
        } catch (RedisException $e) {
            //todo handle err
        }
    }

    public static function pop(): array|null|false
    {
        try {
            $redis = self::getRedis();
            $redis->setOption(\Redis::OPT_READ_TIMEOUT, -1);
            return $redis->blPop(self::keys(), 0);
        } catch (RedisException $e) {
            //todo handle err
            return null;
        }
    }

    public static function keys(): array
    {
        return [self::PAYLOAD];
    }

    private static function getRedis(): \Redis
    {
        return Redis::getInstance();
    }
}
