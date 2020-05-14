<?php

namespace App\Tests\Helper\Provider;

use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Enum\LanguagesEnum;
use App\Enum\WordStatus;
use Faker\Generator;
use Faker\Provider\Base;

class WordProvider extends Base
{
    /** @var TranslationProvider */
    private $translationProvider;

    /**
     * WordProvider constructor.
     * @param Generator $generator
     * @param TranslationProvider $translationProvider
     */
    public function __construct(Generator $generator, TranslationProvider $translationProvider)
    {
        parent::__construct($generator);
        $this->translationProvider = $translationProvider;
    }

    public function wordText() : string
    {
        return $this->generator->word;
    }

    public function language(): string
    {
        return $this->generator->randomElement(LanguagesEnum::getArray());
    }

    public function status(): string
    {
        return $this->generator->randomElement(WordStatus::getArray());
    }

    public function translation(): Translation
    {
        return $this->translation();
    }

    public function Verb($random =false, $nbTranslation = 1) : Verb
    {
        if ($random) {
            $nbTranslation = rand(0,3);
        }

        $translations = [];
        for ($i = 0; $i < $nbTranslation; $i++)
        {
            $translations[] = $this->translationProvider->translation();
        }

        $verb = new Verb();
        $verb
            ->setText($this->wordText())
            ->setLanguage($this->language())
            ->setTranslations($translations)
        ;

        return $verb;
    }
}