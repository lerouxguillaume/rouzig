<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataTransformer\WordDataTransformer;
use App\Dto\WordDto;
use App\Entity\Search;
use App\Service\SearchService;
use App\Service\WordServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WordDataProvider implements CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var WordServiceInterface */
    private $wordService;

    /** @var SearchService */
    private $searchService;

    /** @var WordDataTransformer */
    private $wordDataTransformer;

    /** @var EntityManagerInterface */
    private $managerRegistry;

    /**
     * WordDataProvider constructor.
     * @param WordServiceInterface $wordService
     * @param SearchService $searchService
     * @param WordDataTransformer $wordDataTransformer
     * @param EntityManagerInterface $managerRegistry
     */
    public function __construct(
        WordServiceInterface $wordService,
        SearchService $searchService,
        WordDataTransformer $wordDataTransformer,
        EntityManagerInterface $managerRegistry
    ) {
        $this->wordService = $wordService;
        $this->searchService = $searchService;
        $this->wordDataTransformer = $wordDataTransformer;
        $this->managerRegistry = $managerRegistry;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        if (isset($context['filters'])) {
            $filters = $context['filters'];
            if (isset($filters['search'])) {
                $queryResult= $this->wordService->search($filters['search']);
            } elseif (isset($filters['status'])) {
                $queryResult= $this->wordService->findByStatus($filters['status']);
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
            $result[] = $this->wordDataTransformer->populateDto($word);
        }

        return new ArrayCollection($result);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->wordService->findById($id);

        return empty($item) ? null : $this->wordDataTransformer->populateDto($item);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return WordDto::class === $resourceClass;
    }
}