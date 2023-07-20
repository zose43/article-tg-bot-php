<?php

declare(strict_types = 1);

namespace Bot;

use Throwable;
use Bot\Components\Redis;
use Bot\Components\Queue;
use Symfony\Component\Process\Process;

final class Processor
{
    public function handleRequest(): void
    {
        $redis = Redis::getInstance();
        try {
            $body = file_get_contents('php://input');
            if (!empty($body)) {
                $redis->rPush(Queue::PAYLOAD, $body);
            }
        } catch (Throwable $e) {
            //todo handle err
            file_put_contents('xxx/webhook/' . uniqid('tg_bot', true), 'error');
        }
    }

    public function runWorkers(int $num): void
    {
        //todo check and log
        for ($i = 1; $i <= $num; $i++) {
            $process = new Process(['php', 'bot.php', 'bot/watch'], timeout: null);
            $process->start();
        }
    }

    private function watch(EventManager $manager): void
    {
        while (true) {
            [$queue, $msg] = Queue::pop();
            if (!$queue) {
                //todo handle err
            }
            $manager->handleEvent((string)$msg);
        }
    }

    public function run(string $cmd, EventManager $manager, array $args = []): never
    {
        match ($cmd) {
            'bot/run' => $this->runWorkers((int)$args[0]),
            'bot/watch' => $this->watch($manager),
            default => exit(1)
        };
        exit(0);
    }
}
