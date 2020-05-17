<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\SearchDto;
use App\Entity\Search;
use App\Repository\Paginator;
use App\Service\SearchService;
use Doctrine\Common\Collections\Criteria;

class SearchDataProvider implements CollectionDataProviderInterface, RestrictedDataProviderInterface, ItemDataProviderInterface
{
    /** @var SearchService */
    private $searchService;

    /**
     * @param SearchService $searchService
     */
    public function __construct(
        SearchService $searchService
    ) {
        $this->searchService = $searchService;
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
        /** @var Search $search */
        foreach ($queryResult as $search) {
            yield $search->getDto();
        }
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->searchService->find($id);
        return !empty($item) ? $item->getDto() : null;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return SearchDto::class === $resourceClass;
    }
}