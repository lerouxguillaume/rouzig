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
    /**
     * WordProvider constructor.
     * @param Generator $generator
     */
    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
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

    public function Verb($language = null) : Verb
    {
        $verb = new Verb();
        $verb
            ->setText($this->wordText())
            ->setLanguage($this->language())
        ;

        return $verb;
    }
}