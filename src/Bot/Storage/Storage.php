<?php

namespace Bot\Storage;

use Bot\Models\Stuff;
use Bot\Models\Dto\Payload;

interface Storage
{
    public function pickRandom(Payload $payload): ?Stuff;

    public function save(Payload $payload): void;

    public function remove(Payload $payload): void;

    public function isExist(Payload $payload): bool;

    public function update(array $values, array $criteria): void;
}
