<?php

namespace App\Enum;

use Doctrine\Common\Annotations\Annotation\Enum;

class LanguagesEnum implements EnumInterface
{
    const FR = 'fr';
    const BR = 'br';

    public static function getArray(): array
    {
        return [
            self::FR,
            self::BR
        ];
    }

    public static function get(string $key)
    {
        return self::getArray()[$key];
    }
}