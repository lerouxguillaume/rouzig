<?php


namespace App\Tests\Helper\Provider;

use App\Entity\Translation;
use App\Enum\LanguagesEnum;
use App\Enum\WordStatus;
use App\EventSuscriber\WordWorkflow;
use Faker\Generator;
use Faker\Provider\Base;

class TranslationProvider extends Base
{
    /** @var ExampleProvider */
    private $exampleProvider;
    /** @var WordProvider */
    private $wordProvider;

    /**
     * TranslationProvider constructor.
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
        $this->wordProvider = new WordProvider($generator);
        $this->exampleProvider = new ExampleProvider($generator);
    }

    public function translation($language = null, $random =false, $nbExample = 1): Translation
    {
        if ($random) {
            $nbExample = rand(0,3);
        }

        $examples = [];
        for ($i = 0; $i < $nbExample; $i++)
        {
            $examples[] = $this->exampleProvider->example();
        }

        $translation = new Translation();
        $translation
            ->setOriginalWord($this->wordProvider->Verb($language, false, 0))
            ->setTranslatedWord($this->wordProvider->Verb($language, false, 0))
            ->setExamples($examples)
            ->setStatus(WordWorkflow::PLACE_PENDING)
        ;

        return $translation;
    }
}