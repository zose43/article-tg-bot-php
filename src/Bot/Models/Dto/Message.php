<?php

declare(strict_types = 1);

namespace Bot\Models\Dto;

final readonly class Message
{
    public function __construct(public int    $messageID,
                                public string $firstname,
                                public string $username,
                                public string $languageCode,
                                public string $text,
                                public int    $chatID) {}
}
