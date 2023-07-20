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
}
