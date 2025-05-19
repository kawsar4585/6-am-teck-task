<?php

namespace App\Enums;

enum Deleted: int
{
    case YES = 1;
    case NO = 0;

    public function getValue(): int
    {
        return match ($this) {
            self::YES => 1,
            self::NO => 0,
        };
    }

    public function getLabel(): string
    {
        return match ($this) {
            self::YES => 'Yes',
            self::NO => 'No',
        };
    }
}
