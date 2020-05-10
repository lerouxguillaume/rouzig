<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\ExampleDto;
use App\Entity\Example;

class ExampleDataTransformer
{

    public function transform($object, string $to)
    {
        if ($object instanceof Example && $to === ExampleDto::class) {
            return $this->entityToDto($object);
        } elseif ($object instanceof ExampleDto && $to === Example::class) {
            return $this->dtoToEntity($object);
        } else {
            throw new \LogicException('Transformation not supported');
        }
    }

    private function entityToDto(Example $example): ExampleDto
    {
        $output = new ExampleDto();
        $output
            ->setId($example->getId())
            ->setToText($example->getToText())
            ->setFromText($example->getFromText())
        ;

        return $output;
    }

    private function dtoToEntity(ExampleDto $example): Example
    {
        $output = new Example();
        $output
            ->setId($example->getId())
            ->setFromText($example->getFromText())
            ->setToText($example->getFromText())
        ;

        return $output;
    }
}