<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataTransformer\WordDataTransformer;
use App\Dto\WordDto;
use App\Entity\Search;
use App\Entity\WordObject;
use App\Service\WordServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WordDataProvider implements CollectionDataProviderInterface, ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var WordServiceInterface */
    private $wordService;

    /** @var WordDataTransformer */
    private $wordDataTransformer;

    /** @var EntityManagerInterface */
    private $managerRegistry;

    /**
     * @param EntityManagerInterface $managerRegistry
     * @param WordServiceInterface $wordService
     * @param WordDataTransformer $wordDataTransformer
     */
    public function __construct(
        EntityManagerInterface $managerRegistry,
        WordServiceInterface $wordService,
        WordDataTransformer $wordDataTransformer
    ) {
        $this->managerRegistry = $managerRegistry;
        $this->wordService = $wordService;
        $this->wordDataTransformer = $wordDataTransformer;
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
            $search = new Search();
            $search
                ->setText($filters['search'])
            ;
            $search->countAdd();
            $this->managerRegistry->persist($search);
            $this->managerRegistry->flush();
        }
        $result = [];
        foreach ($queryResult as $word) {
            $result[] = $this->wordDataTransformer->transform($word, WordDto::class);
        }

        return new ArrayCollection($result);
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->wordService->findById($id);
        return empty($item) ? null : $this->wordDataTransformer->transform($item, WordDto::class);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return WordDto::class === $resourceClass;
    }
}