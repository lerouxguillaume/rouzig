<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\TranslationDto;
use App\Entity\Search;
use App\Service\SearchService;
use App\Service\TranslationService;
use Doctrine\Common\Collections\ArrayCollection;
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
        if (isset($context['filters'])) {
            $filters = $context['filters'];
            if (isset($filters['search'])) {
                $queryResult= $this->translationService->search($filters['search']);
            } elseif (isset($filters['status'])) {
                $queryResult= $this->translationService->findByStatus($filters['status']);
            } else {
                throw new BadRequestHttpException('invalid filter');
            }
        } else {
            throw new BadRequestHttpException('missing filter');
        }

        if (empty($queryResult) && isset($filters['search'])) {
            if (!($search = $this->searchService->find($filters['search']))) {
                $search = new Search();
                $search
                    ->setText($filters['search'])
                ;
            }

            $search->countAdd();
            $this->searchService->save($search);
        }
        $result = [];
        foreach ($queryResult as $word) {
            $result[] = $word->getDto();
        }

        return new ArrayCollection($result);
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