<?php

namespace App\Enum;

class WordTypeEnum implements EnumInterface
{
    const ADJECTIVE = 'adjective';
    const ADVERB = 'adverb';
    const CONJUNCTION = 'conjunction';
    const NOUN = 'noun';
    const PREPOSITION = 'preposition';
    const PRONOUN = 'pronoun';
    const VERB = 'verb';
    const OTHER = 'other';

    public static function getArray(): array
    {
        return [
            self::ADJECTIVE,
            self::ADVERB,
            self::CONJUNCTION,
            self::NOUN,
            self::PREPOSITION,
            self::PRONOUN,
            self::VERB,
            self::OTHER
        ];    }

    public static function get(string $key)
    {
        return self::getArray()[$key];
    }
}