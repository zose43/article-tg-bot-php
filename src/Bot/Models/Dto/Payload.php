<?php

declare(strict_types = 1);

namespace Bot\Models\Dto;

final readonly class Payload
{
    public Message $message;

    public function __construct(public int $update_id, array $message)
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

    public function toArray(array $attributes = []): array
    {
        if (empty($attributes)) {
            return [
                'update_id' => $this->update_id,
                'message_id' => $this->message->messageID,
                'first_name' => $this->message->firstname,
                'username' => $this->message->username,
                'language_code' => $this->message->languageCode,
                'url' => $this->message->url,
                'chat_id' => $this->message->chatID,
            ];
        }

        $values =  array_map(fn(string $v) => empty($this->toArray()[$v])
            ? null
            : $this->toArray()[$v], $attributes);
        return array_combine($attributes, $values);
    }
}
