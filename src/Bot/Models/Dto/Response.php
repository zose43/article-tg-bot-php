<?php

declare(strict_types = 1);

namespace Bot\Models\Dto;

final readonly class Response
{
    public function __construct(public bool   $status,
                                public int    $messageID,
                                public int    $chatID,
                                public string $firstname,
                                public string $username
    ) {}
}
