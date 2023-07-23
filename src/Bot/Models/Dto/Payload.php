<?php

declare(strict_types = 1);

namespace Bot\Models\Dto;

use Bot\Models\BaseModel;

class Payload extends BaseModel
{
    protected Message $message;

    public function __construct(private int $update_id, array $message)
    {
        $this->message = new Message(
            $message['message_id'],
            $message['from']['first_name'],
            $message['from']['username'],
            $message['from']['language_code'],
            $message['text'],
            $message['chat']['id']
        );
    }

    public function getMessage(): Message
    {
        return $this->message;
    }

    public function setMessage(Message $message): Payload
    {
        $this->message = $message;
        return $this;
    }

    public function getUpdateId(): int
    {
        return $this->update_id;
    }

    public function setUpdateId(int $update_id): Payload
    {
        $this->update_id = $update_id;
        return $this;
    }

    protected function getAttributes(): array
    {
        return [
            'update_id' => $this->getUpdateId(),
            'message_id' => $this->getMessage()->messageID,
            'first_name' => $this->getMessage()->firstname,
            'username' => $this->getMessage()->username,
            'language_code' => $this->getMessage()->languageCode,
            'url' => $this->getMessage()->url,
            'chat_id' => $this->getMessage()->chatID,
        ];
    }
}
