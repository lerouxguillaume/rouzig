<?php

namespace App\DataTransformer;

use ApiPlatform\Core\DataTransformer\DataTransformerInterface;
use App\Dto\ExampleDto;
use App\Dto\SearchDto;
use App\Entity\Example;
use App\Entity\Search;

class SearchDataTransformer
{

    public function transform($object, string $to, $context = [])
    {
        if ($object instanceof Search && $to === SearchDto::class) {
            return $this->entityToDto($object, $context);
        } elseif ($object instanceof SearchDto && $to === Search::class) {
            return $this->dtoToEntity($object, $context);
        } else {
            throw new \LogicException('Transformation not supported');
        }
    }

    private function entityToDto(Search $search, $context = []): SearchDto
    {
        $output = new SearchDto();
        $output
            ->setText($search->getText())
            ->setToLanguage($search->getToLanguage())
            ->setFromLanguage($search->getFromLanguage())
            ->setCount($search->getCount())
            ->setUpdatedAt($search->getUpdatedAt())
        ;

        return $output;
    }

    private function dtoToEntity(SearchDto $search, $context = []): Search
    {
        return new Search(); //Should not happen
    }
}