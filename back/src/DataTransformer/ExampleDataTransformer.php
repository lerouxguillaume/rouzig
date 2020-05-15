<?php

namespace App\DataTransformer;

use App\Dto\ExampleDto;
use App\Entity\Example;

class ExampleDataTransformer implements DataTransformerInterface
{

    private function entityToDto(Example $example, $context = []): ExampleDto
    {

    }

    private function dtoToEntity(ExampleDto $example, $context = []): Example
    {

    }

    public function populateDto($example)
    {
        $exampleDto = new ExampleDto();
        $exampleDto
            ->setId($example->getId())
            ->setToText($example->getToText())
            ->setFromText($example->getFromText())
        ;

        return $exampleDto;
    }

    public function populateEntity($exampleDto, $example = null, $context = [])
    {

        if (empty($example)) {
            $example = new Example();
        }

        $example
            ->setId($exampleDto->getId())
            ->setFromText($exampleDto->getFromText())
            ->setToText($exampleDto->getToText())
            ->setFromLanguage($context['fromLanguage'] ?? null)
            ->setToLanguage($context['toLanguage'] ?? null)
        ;

        return $example;
    }
}