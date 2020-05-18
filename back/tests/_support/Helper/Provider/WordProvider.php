<?php

namespace App\Tests\Helper\Provider;

use App\Entity\Translation;
use App\Entity\Word\Verb;
use App\Enum\LanguagesEnum;
use App\Enum\WordStatus;
use App\EventSuscriber\WordWorkflow;
use Faker\Generator;
use Faker\Provider\Base;
use Symfony\Component\Workflow\WorkflowEvents;

class WordProvider extends Base
{
    /** @var TranslationProvider */
    private $translationProvider;

    /**
     * WordProvider constructor.
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
        $this->translationProvider = new TranslationProvider($generator, $this, new ExampleProvider($generator));
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

    public function Verb($language = null,  $random =false, $nbTranslation = 1) : Verb
    {
        if ($random) {
            $nbTranslation = rand(0,3);
        }

        $fromLanguage = $language ?? $this->language();
        $toLanguage = $language === LanguagesEnum::BR ?: LanguagesEnum::FR;

        $translations = [];
        for ($i = 0; $i < $nbTranslation; $i++)
        {
            $translations[] = $this->translationProvider->translation($toLanguage);
        }

        $verb = new Verb();
        $verb
            ->setStatus(WordWorkflow::PLACE_PENDING)
            ->setText($this->wordText())
            ->setLanguage($fromLanguage)
            ->setTranslations($translations)
        ;

        return $verb;
    }
}