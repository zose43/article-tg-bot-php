<?php

declare(strict_types = 1);

namespace Bot\Storage\Database;

use Bot\Models\Stuff;
use Bot\Storage\Storage;
use Bot\Components\Logger;
use Bot\Models\Dto\Payload;
use Doctrine\DBAL\Exception;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DbStorage implements Storage
{
    private Connection $connection;

    public function __construct()
    {
        $connectionParams = [
            'dbname' => getenv('POSTGRES_DB'),
            'user' => getenv('POSTGRES_USER'),
            'password' => getenv('POSTGRES_PASSWORD'),
            'host' => getenv('POSTGRES_HOST'),
            'driver' => 'pdo_pgsql',
        ];
        try {
            $this->connection = DriverManager::getConnection($connectionParams);
        } catch (Exception $e) {
            Logger::getLogger()->critical("can't make dbal connection", [
                'msg' => $e->getMessage()
            ]);
        }
    }

    public function pickRandom(string $username, Payload $payload): ?Stuff
    {
        return null;
    }

    public function save(Payload $payload): void
    {
        $this->connection->insert($this->getTable(),
            $payload->toArray([
                'chat_id',
                'username',
                'first_name',
                'url'
            ]));
    }

    public function remove(Payload $payload): void
    {
        // TODO: Implement remove() method.
    }

    public function isExist(Payload $payload): bool
    {
        return (bool)$this->connection->createQueryBuilder()
            ->select('chat_id')
            ->from($this->getTable())
            ->where('chat_id = :chat_id')
            ->andWhere('url = :url')
            ->andWhere('username = :username')
            ->setParameters([
                'chat_id' => $payload->message->chatID,
                'username' => $payload->message->username,
                'url' => $payload->message->url,
            ])->fetchOne();
    }

    public function getTable(): string
    {
        return Stuff::getTable();
    }
}
