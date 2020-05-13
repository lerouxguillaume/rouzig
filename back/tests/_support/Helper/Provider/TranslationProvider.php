<?php


namespace App\Tests\Helper\Provider;

use App\Entity\Translation;
use App\Enum\LanguagesEnum;
use App\Enum\WordStatus;
use Faker\Generator;
use Faker\Provider\Base;

class TranslationProvider extends Base
{
    /** @var ExampleProvider */
    private $exampleProvider;

    /**
     * TranslationProvider constructor.
     * @param Generator $generator
     * @param ExampleProvider $exampleProvider
     */
    public function __construct(Generator $generator, ExampleProvider $exampleProvider)
    {
        parent::__construct($generator);
        $this->exampleProvider = $exampleProvider;
    }

    public function translationText() : string
    {
        return $this->generator->word;
    }

    public function language(): string
    {
        return $this->generator->randomElement(LanguagesEnum::getArray());
    }

    public function description(): string
    {
        return $this->generator->text;
    }

    public function status(): string
    {
        return $this->generator->randomElement(WordStatus::getArray());
    }

    public function translation($random =false, $nbExample = 1): Translation
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
            ->setText($this->translationText())
            ->setLanguage($this->language())
            ->setDescription($this->description())
            ->setExamples($examples)
        ;

        return $translation;
    }
}