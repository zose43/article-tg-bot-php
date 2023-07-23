<?php

declare(strict_types = 1);

namespace Bot\Models;

abstract class BaseModel
{
    public function toArray(array $attributes = []): array
    {
        if (empty($attributes)) {
            return $this->getAttributes();
        }

        $values = [];
        foreach ($this->getAttributes() as $attribute => $value) {
            if (in_array($attribute, $attributes, true)) {
                $values[$attribute] = $value === '' ? null : $value;
            }
        }
        return $values;
    }

    abstract protected function getAttributes(): array;
}
