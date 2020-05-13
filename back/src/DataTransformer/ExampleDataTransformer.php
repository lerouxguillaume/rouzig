<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\ExampleDto;
use App\Entity\Example;

class ExampleDataTransformer
{

    public function transform($object, string $to, $context = [])
    {
        if ($object instanceof Example && $to === ExampleDto::class) {
            return $this->entityToDto($object, $context);
        } elseif ($object instanceof ExampleDto && $to === Example::class) {
            return $this->dtoToEntity($object, $context);
        } else {
            throw new \LogicException('Transformation not supported');
        }
    }

    private function entityToDto(Example $example, $context = []): ExampleDto
    {
        $output = new ExampleDto();
        $output
            ->setId($example->getId())
            ->setToText($example->getToText())
            ->setFromText($example->getFromText())
        ;

        return $output;
    }

    private function dtoToEntity(ExampleDto $example, $context = []): Example
    {
        $output = new Example();

        $output
            ->setId($example->getId())
            ->setFromText($example->getFromText())
            ->setToText($example->getToText())
            ->setFromLanguage($context['fromLanguage'] ?? null)
            ->setToLanguage($context['toLanguage'] ?? null)
        ;

        return $output;
    }
}