<?php

declare(strict_types = 1);

namespace Bot\Components;

final class Redis
{
    private static \Redis $instance;

    public static function getInstance(): \Redis
    {
        if (empty(self::$instance)) {
            self::$instance = new \Redis();
            self::$instance->connect(
                getenv('REDIS_HOST'),
                (int)getenv('REDIS_PORT'),
                1.5);
        }
        return self::$instance;
    }
}
