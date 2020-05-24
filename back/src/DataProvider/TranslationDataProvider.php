<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\TranslationDto;
use App\Entity\Search;
use App\Repository\Paginator;
use App\Service\SearchService;
use App\Service\TranslationService;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class TranslationDataProvider implements CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var TranslationService */
    private $translationService;

    /** @var SearchService */
    private $searchService;

    /** @var EntityManagerInterface */
    private $managerRegistry;

    /**
     * WordDataProvider constructor.
     * @param TranslationService $translationService
     * @param SearchService $searchService
     * @param EntityManagerInterface $managerRegistry
     */
    public function __construct(
        TranslationService $translationService,
        SearchService $searchService,
        EntityManagerInterface $managerRegistry
    ) {
        $this->translationService = $translationService;
        $this->searchService = $searchService;
        $this->managerRegistry = $managerRegistry;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        $criteria = new Criteria();

        $itemsPerPage = $context['filters']['itemPerPage'] ?? 10;
        $page = ($context['filters']['page'] ?? 1) - 1; // Starting with page 1

        $firstResult = $page > 0 ? $itemsPerPage * $page : 0;

        if (isset($context['filters'])) {
            $filters = $context['filters'];
            if (isset($filters['status'])) {
                $criteria->andWhere(Criteria::expr()->eq('status', $filters['status']));
            } else {
                throw new BadRequestHttpException('invalid filter');
            }
        } else {
            throw new BadRequestHttpException('missing filter');
        }

        $criteria
            ->setFirstResult($firstResult)
            ->setMaxResults($itemsPerPage)
        ;

        $items = $this->translationService->findByCriteria($criteria);
        $count= $this->translationService->countByCriteria($criteria);

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
        $item = $this->translationService->findById($id);

        return empty($item) ? null : $item->getDto();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return TranslationDto::class === $resourceClass;
    }
}