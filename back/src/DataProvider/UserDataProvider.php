<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\CollectionDataProviderInterface;
use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\DataTransformer\UserDataTransformer;
use App\DataTransformer\WordDataTransformer;
use App\Dto\WordDto;
use App\Entity\Search;
use App\Service\SearchService;
use App\Service\UserService;
use App\Service\WordServiceInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var UserService */
    private $userService;

    /** @var UserDataTransformer */
    private $userDataTransformer;

    /**
     * @return UserService
     */
    public function getUserService(): UserService
    {
        return $this->userService;
    }

    /**
     * @param UserService $userService
     * @return UserDataProvider
     */
    public function setUserService(UserService $userService): UserDataProvider
    {
        $this->userService = $userService;
        return $this;
    }

    /**
     * @return UserDataTransformer
     */
    public function getUserDataTransformer(): UserDataTransformer
    {
        return $this->userDataTransformer;
    }

    /**
     * @param UserDataTransformer $userDataTransformer
     * @return UserDataProvider
     */
    public function setUserDataTransformer(UserDataTransformer $userDataTransformer): UserDataProvider
    {
        $this->userDataTransformer = $userDataTransformer;
        return $this;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->userService->findById($id);

        return empty($item) ? null : $this->userDataTransformer->populateDto($item);
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return WordDto::class === $resourceClass;
    }
}