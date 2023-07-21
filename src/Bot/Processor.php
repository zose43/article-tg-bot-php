<?php

declare(strict_types = 1);

namespace Bot;

use Bot\Components\Queue;
use Bot\Components\Logger;
use Symfony\Component\Process\Process;

final class Processor
{
    public function handleRequest(): void
    {
        $body = file_get_contents('php://input');
        if (!empty($body)) {
            Queue::push($body);
        } else {
            // todo throw custom exception
            Logger::getLogger(Logger::PRODUCER, Logger::PRODUCER)->critical('tg-webhook send empty response');
        }
    }

    public function runWorkers(): void
    {
        //todo make concurrency
        $process = new Process(['php', 'bot.php', 'bot/watch'], timeout: null);
        $process->start();
        Logger::getLogger()->info('watch php process started');
        $process->wait();
        Logger::getLogger()->info('watch php process stopped');
    }

    private function watch(EventManager $manager): void
    {
        while (true) {
            [$queue, $msg] = Queue::pop();
            if (!$queue) {
                Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error("can't handle payload from queue, msg is invalid", [
                    'queue' => $queue,
                    'msg' => $msg,
                ]);
            }
            $manager->handleEvent((string)$msg);
        }
    }

    public function run(string $cmd, EventManager $manager, array $args = []): void
    {
        match ($cmd) {
            'bot/run' => $this->runWorkers(),
            'bot/watch' => $this->watch($manager),
            default => Logger::getLogger()->warning("can't recognize command", [
                'cmd' => $cmd,
                'args' => $args,
            ])
        };
    }
}
