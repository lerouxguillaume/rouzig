<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataTransformer\SearchDataTransformer;
use App\Dto\SearchDto;
use App\Repository\Paginator;
use App\Service\SearchService;
use Doctrine\Common\Collections\Criteria;

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
        $criteria = new Criteria();

        $itemsPerPage = $context['filters']['itemPerpage'] ?? 2;
        $page = ($context['filters']['page'] ?? 1) - 1; // Starting with page 1

        $firstResult = $page > 0 ? $itemsPerPage * $page : 0;

        $criteria
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage)
            ->orderBy(['count' => Criteria::DESC])
        ;

        $items = $this->searchService->findByCriteria($criteria);
        $count= $this->searchService->countByCriteria($criteria);

        return new Paginator($this->getResults($items), $firstResult, $itemsPerPage, $count);
    }

    private function getResults($queryResult): \Generator
    {
        foreach ($queryResult as $word) {
            yield $this->searchDataTransformer->transform($word, SearchDto::class);
        }
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->searchService->find($id);
        return empty($item) ? null : $this->searchDataTransformer->transform($item, SearchDto::class);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return SearchDto::class === $resourceClass;
    }
}