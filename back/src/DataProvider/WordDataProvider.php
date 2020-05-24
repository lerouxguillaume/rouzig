<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\TranslationDto;
use App\Entity\Search;
use App\Service\SearchService;
use App\Service\TranslationService;
use App\Service\WordService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class WordDataProvider implements ItemDataProviderInterface, CollectionDataProviderInterface
{
    /** @var WordService */
    private $wordService;

    /** @var SearchService */
    private $searchService;

    /**
     * WordDataProvider constructor.
     * @param WordService $wordService
     * @param SearchService $searchService
     */
    public function __construct(WordService $wordService, SearchService $searchService)
    {
        $this->wordService = $wordService;
        $this->searchService = $searchService;
    }

    public function getCollection(string $resourceClass, string $operationName = null, array $context = [])
    {
        if (isset($context['filters'])) {
            $filters = $context['filters'];
            if (isset($filters['search'])) {
                $queryResult= $this->wordService->search($filters['search']);
            } else {
                throw new BadRequestHttpException('invalid filter');
            }
        } else {
            throw new BadRequestHttpException('missing filter');
        }

        if (empty($queryResult) && isset($filters['search']) &&  !empty($filters['search'])) {
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
        $item = $this->wordService->find($id);

        return empty($item) ? null : $item->getDto();
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return TranslationDto::class === $resourceClass;
    }
}