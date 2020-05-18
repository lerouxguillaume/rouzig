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
    /** @var WordProvider */
    private $wordProvider;

    /**
     * TranslationProvider constructor.
     * @param Generator $generator
     * @param WordProvider $wordProvider
     * @param ExampleProvider $exampleProvider
     */
    public function __construct(Generator $generator, WordProvider $wordProvider ,ExampleProvider $exampleProvider)
    {
        parent::__construct($generator);
        $this->wordProvider = $wordProvider;
        $this->exampleProvider = $exampleProvider;
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
            ->setTranslation($this->wordProvider->Verb($language, false, 0))
            ->setExamples($examples)
        ;

        return $translation;
    }
}