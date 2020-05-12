<?php


namespace App\Tests\Helper\Provider;

use App\Entity\Example;
use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Enum\LanguagesEnum;
use App\Enum\WordStatus;
use Faker\Provider\Base;

class ExampleProvider extends Base
{
    public function toLanguage(): string
    {
        return $this->generator->randomElement(LanguagesEnum::getArray());
    }

    public function fromLanguage(): string
    {
        return $this->generator->randomElement(LanguagesEnum::getArray());
    }

    public function toText(): string
    {
        return $this->generator->text;
    }

    public function fromText(): string
    {
        return $this->generator->randomElement(WordStatus::getArray());
    }

    public function Example(): Example
    {
        $example = new Example();
        $example
            ->setToText($this->toText())
            ->setFromText($this->fromText())
            ->setToLanguage($this->fromLanguage())
            ->setFromLanguage($this->toLanguage())
        ;

        return $example;
    }
}