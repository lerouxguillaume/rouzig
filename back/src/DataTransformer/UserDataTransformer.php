<?php

namespace App\DataTransformer;

use App\Dto\ExampleDto;
use App\Dto\UserDto;
use App\Entity\Example;
use App\Entity\User;

class UserDataTransformer implements DataTransformerInterface
{
    public function populateDto($user)
    {
        $exampleDto = new UserDto();
        $exampleDto
            ->setId($user->getId())
            ->setUsername($user->getUsername())
            ->setEmail($user->getEmail())
        ;

        return $exampleDto;
    }

    /**
     * @param UserDto $userDto
     * @param User $user
     * @param array $context
     * @return User
     */
    public function populateEntity($userDto, $user = null, $context = [])
    {

        if (empty($user)) {
            $user = new User();
        }

        $user
            ->setId($userDto->getId())
            ->setEmail($userDto->getEmail())
            ->setUsername($userDto->getUsername())
            ->setPlainPassword($userDto->getPassword())
        ;

        return $user;
    }
}