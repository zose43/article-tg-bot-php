<?php

declare(strict_types = 1);

namespace Bot\Models;

class Stuff extends BaseModel
{
    private int $chat_id;
    private string $username;
    private string $url;
    private ?string $first_name = null;
    private bool $is_read;

    public function __construct(array $data)
    {
        $this->chat_id = $data['chat_id'];
        $this->username = $data['username'];
        $this->url = $data['url'];
        $this->first_name = $data['first_name'];
        $this->is_read = $data['is_read'];
    }

    public function getChatId(): int
    {
        return $this->chat_id;
    }

    public function setChatId(int $chat_id): Stuff
    {
        $this->chat_id = $chat_id;
        return $this;
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function setUsername(string $username): Stuff
    {
        $this->username = $username;
        return $this;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function setUrl(string $url): Stuff
    {
        $this->url = $url;
        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->first_name;
    }

    public function setFirstName(?string $first_name): Stuff
    {
        $this->first_name = $first_name;
        return $this;
    }

    public function isIsRead(): bool
    {
        return $this->is_read;
    }

    public function setIsRead(bool $is_read): Stuff
    {
        $this->is_read = $is_read;
        return $this;
    }

    public static function getTable(): string
    {
        return 'stuff';
    }

    protected function getAttributes(): array
    {
        return [
            'chat_id' => $this->chat_id,
            'username' => $this->username,
            'url' => $this->url,
            'first_name' => $this->first_name,
            'is_read' => $this->is_read,
        ];
    }
}
