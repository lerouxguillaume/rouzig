<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataTransformer\SearchDataTransformer;
use App\Dto\SearchDto;
use App\Dto\WordDto;
use App\Service\SearchService;
use Doctrine\Common\Collections\ArrayCollection;

class SearchDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{
    /** @var SearchService */
    private $searchService;

    /** @var SearchDataTransformer */
    private $searchDataTransformer;

    /**
     * @param SearchService $searchService
     * @param SearchDataTransformer $searchDataTransformer
     */
    public function __construct(
        SearchService $searchService,
        SearchDataTransformer $searchDataTransformer
    ) {
        $this->searchService = $searchService;
        $this->searchDataTransformer = $searchDataTransformer;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $queryResult= $this->searchService->findAll();

        $result = [];
        foreach ($queryResult as $word) {
            $result[] = $this->searchDataTransformer->transform($word, SearchDto::class);
        }

        return new ArrayCollection($result);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->searchService->find($id);
        return empty($item) ? null : $this->searchDataTransformer->transform($item, WordDto::class);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return SearchDto::class === $resourceClass;
    }
}