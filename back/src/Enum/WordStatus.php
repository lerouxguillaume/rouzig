<?php

namespace App\Enum;

use App\EventSuscriber\WordWorkflow;

class WordStatus implements EnumInterface
{
    const CREATED = WordWorkflow::PLACE_CREATED;
    const PENDING = WordWorkflow::PLACE_PENDING;
    const REVIEW = WordWorkflow::PLACE_REVIEW;
    const DELETED = WordWorkflow::PLACE_DELETED;
    const APPROVED = WordWorkflow::PLACE_ACCEPTED;
    const DEFINITION = 'definition';

    public static function getArray(): array
    {
        return [
            self::CREATED,
            self::APPROVED,
            self::PENDING,
            self::REVIEW,
            self::DELETED,
        ];
    }

    public static function get(string $key)
    {
        return self::getArray()[$key];
    }
}