<?php


namespace App\DataTransformer;

use App\Dto\ExampleDto;
use App\Dto\TranslationDto;
use App\Entity\Example;
use App\Entity\Translation;

class TranslationDataTransformer implements DataTransformerInterface
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

    private function dtoToEntity(TranslationDto $translation, $context = []): Translation
    {

    }

    /**
     * @param Translation $translation
     * @return TranslationDto
     */
    public function populateDto($translation)
    {
        $translationDto = new TranslationDto();
        $translationDto
            ->setId($translation->getId())
            ->setWord($translation->getText())
            ->setDescription($translation->getDescription())
            ->setLanguage($translation->getLanguage())
        ;

        /** @var Example $example */
        foreach ($translation->getExamples() as $example) {
            $translationDto->addExample($this->exampleDataTransformer->populateDto($example));
        }

        return $translationDto;
    }

    /**
     * @param TranslationDto $translationDto
     * @param Translation $translation
     * @param array $context
     * @return Translation
     */
    public function populateEntity($translationDto, $translation = null, $context = [])
    {
        if (empty($translation)) {
            $translation = new Translation();

        }

        $translation
            ->setText($translationDto->getWord())
            ->setDescription($translationDto->getDescription())
            ->setLanguage($translationDto->getLanguage())
        ;


        $updatedExamples = [];

        /** @var ExampleDto $exampleDto */
        foreach ($translationDto->getExamples() as $exampleDto) {
            $example = ($translationDto->getId() ? $translation->getExampleById($translationDto->getId()) : null);
            $updatedExamples[] = $this->exampleDataTransformer->populateEntity($exampleDto, $example, array_merge($context, ['toLanguage' => $translation->getLanguage()]));
        }

        $translation->setExamples($updatedExamples);

        return $translation;
    }
}