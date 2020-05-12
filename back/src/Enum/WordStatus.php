<?php

namespace App\Enum;

use Doctrine\Common\Annotations\Annotation\Enum;

class WordStatus implements EnumInterface
{
    const APPROVED = 'approved';
    const PENDING = 'pending';
    const DELETED = 'deleted';

    public static function getArray(): array
    {
        return [
            self::APPROVED,
            self::PENDING,
            self::DELETED
        ];
    }

    public static function get(string $key)
    {
        return self::getArray()[$key];
    }
}