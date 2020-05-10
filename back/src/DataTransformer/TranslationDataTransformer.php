<?php


namespace App\DataTransformer;

use App\Dto\ExampleDto;
use App\Dto\TranslationDto;
use App\Entity\Example;
use App\Entity\Translation;

class TranslationDataTransformer
{
    /** @var ExampleDataTransformer */
    private $exampleDataTransformer;

    /**
     * TranslationDataTransformer constructor.
     * @param ExampleDataTransformer $exampleDataTransformer
     */
    public function __construct(ExampleDataTransformer $exampleDataTransformer)
    {
        $this->exampleDataTransformer = $exampleDataTransformer;
    }

    public function transform($object, string $to)
    {
        if ($object instanceof Translation && $to === TranslationDto::class) {
            return $this->entityToDto($object);
        } elseif ($object instanceof TranslationDto && $to === Translation::class) {
            return $this->dtoToEntity($object);
        } else {
            throw new \LogicException('Transformation not supported');
        }
    }

    private function entityToDto(Translation $translation): TranslationDto
    {
        $output = new TranslationDto();
        $output
            ->setId($translation->getId())
            ->setWord($translation->getText())
            ->setDescription($translation->getDescription())
            ->setLanguage($translation->getLanguage())
        ;

        /** @var Example $example */
        foreach ($translation->getExamples() as $example) {
            $output->addExample($this->exampleDataTransformer->transform($example, ExampleDto::class));
        }

        return $output;
    }

    private function dtoToEntity(TranslationDto $translation): Translation
    {
        $output = new Translation();
        $output
            ->setId($translation->getId())
            ->setText($translation->getWord())
            ->setDescription($translation->getDescription())
            ->setLanguage($translation->getLanguage())
        ;

        /** @var ExampleDto $example */
        foreach ($translation->getExamples() as $example) {
            $output->addExample($this->exampleDataTransformer->transform($example, Example::class));
        }

        return $output;
    }
}