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

class WordDataProvider implements ItemDataProviderInterface
{
    /** @var WordService */
    private $wordService;

    /**
     * WordDataProvider constructor.
     * @param WordService $wordService
     */
    public function __construct(
        WordService $wordService
    ) {
        $this->wordService = $wordService;
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