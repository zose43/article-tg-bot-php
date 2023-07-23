<?php

declare(strict_types = 1);

namespace Bot;

use Exception;
use Bot\Storage\Storage;
use Bot\Client\HTTPClient;
use Bot\Components\Logger;
use Bot\Models\Dto\Payload;

final readonly class EventManager
{
    public function __construct(
        public Command    $cmd,
        public HTTPClient $client,
        public Storage    $storage) {}

    public function handleEvent(string $msg): void
    {
        try {
            $data = json_decode($msg, true, 512, JSON_THROW_ON_ERROR);
            $payload = new Payload(...$data);
            if ($this->isAdding($payload->getMessage()->url)) {
                $this->cmd->savePage($this->storage, $payload, $this->client);
            } else {
                match ($payload->getMessage()->url) {
                    Command::START => $this->cmd->start($payload, $this->client),
                    Command::HELP => $this->cmd->help($payload, $this->client),
                    Command::RANDOM => $this->cmd->random($this->storage, $payload, $this->client),
                    default => $this->cmd->undefined($payload, $this->client)
                };
            }
        } catch (Exception $e) {
            Logger::getLogger(Logger::CONSUMER, Logger::CONSUMER)->error($e->getMessage(), [
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'msg' => $msg,
            ]);
        }
    }

    private function isAdding(string $msg): bool
    {
        try {
            $url = parse_url($msg);
            return !empty($url['scheme']) && !empty($url['host']);
        } catch (Exception) {
            return false;
        }
    }
}
