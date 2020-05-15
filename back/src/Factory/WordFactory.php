<?php


namespace App\Factory;


use App\Entity\Word\Adjective;
use App\Entity\Word\Adverb;
use App\Entity\Word\Conjunction;
use App\Entity\Word\Noun;
use App\Entity\Word\Other;
use App\Entity\Word\Preposition;
use App\Entity\Word\Pronoun;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use App\Enum\WordTypeEnum;

class WordFactory
{
    public static function create(string $type): WordObject
    {
        switch ($type) {
            case WordTypeEnum::ADJECTIVE:
                return new Adjective();
            case WordTypeEnum::ADVERB:
                return new Adverb();
            case WordTypeEnum::CONJUNCTION:
                return new Conjunction();
            case WordTypeEnum::NOUN:
                return new Noun();
            case WordTypeEnum::PRONOUN:
                return new Pronoun();
            case WordTypeEnum::PREPOSITION:
                return new Preposition();
            case WordTypeEnum::VERB:
                return new Verb();
        }

        return new Other();
    }
}