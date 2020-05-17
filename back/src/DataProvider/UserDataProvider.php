<?php

namespace App\DataProvider;

use ApiPlatform\Core\DataProvider\ItemDataProviderInterface;
use ApiPlatform\Core\DataProvider\RestrictedDataProviderInterface;
use App\Dto\UserDto;
use App\Service\UserService;

class UserDataProvider implements ItemDataProviderInterface, RestrictedDataProviderInterface
{
    /** @var UserService */
    private $userService;

    /**
     * UserDataProvider constructor.
     * @param UserService $userService
     */
    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function getItem(string $resourceClass, $id, string $operationName = null, array $context = [])
    {
        $item = $this->userService->findById($id);

        return !empty($item) ? $item->getDto() : null;
    }

    public function supports(string $resourceClass, string $operationName = null, array $context = []): bool
    {
        return UserDto::class === $resourceClass;
    }
}