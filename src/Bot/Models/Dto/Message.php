<?php

declare(strict_types = 1);

namespace Bot\Models\Dto;

final readonly class Message
{
    public function __construct(public int    $message_id,
                                public string $first_name,
                                public string $username,
                                public string $language_code,
                                public string $text,
                                public int    $chat_id) {}
}
