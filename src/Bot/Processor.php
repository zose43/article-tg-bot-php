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

    public function runWorkers(): void
    {
        //todo make concurrency
        $process = new Process(['php', 'bot.php', 'bot/watch'], timeout: null);
        $process->start();
        while (!$process->isRunning()) {
            //todo log stopped process
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

    public function run(string $cmd, EventManager $manager, array $args = []): void
    {
        match ($cmd) {
            'bot/run' => $this->runWorkers(),
            'bot/watch' => $this->watch($manager),
            default => '' // todo log this
        };
    }
}
