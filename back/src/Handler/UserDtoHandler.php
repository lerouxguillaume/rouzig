<?php

namespace App\Handler;

use App\DataTransformer\UserDataTransformer;
use App\Dto\UserDto;
use App\Entity\User;
use App\Event\UserEvent;
use App\Service\UserService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserDtoHandler
{
    /** @var UserDataTransformer */
    private $userDataTransformer;

    /** @var UserService */
    private $userService;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * UserDtoHandler constructor.
     * @param UserDataTransformer $userDataTransformer
     * @param UserService $userService
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(UserDataTransformer $userDataTransformer, UserService $userService, EventDispatcherInterface $dispatcher)
    {
        $this->userDataTransformer = $userDataTransformer;
        $this->userService = $userService;
        $this->dispatcher = $dispatcher;
    }

    public function create(UserDto $userDto)
    {
        $user = $this->userDataTransformer->populateEntity($userDto);

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::REGISTER);

        $this->userService->save($user);

        return $this->userDataTransformer->populateDto($user);
    }

    public function update(int $id, UserDto $userDto)
    {
        $user = $this->userService->findById($id);

        $updatedUser = $this->userDataTransformer->populateEntity($userDto, $user);

        $this->userService->save($updatedUser);

        return $this->userDataTransformer->populateDto($updatedUser);
    }

    public function delete(UserDto $userDto)
    {
        $user = $this->userService->findById($userDto->getId());

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::DELETE);

        $this->userService->delete($user);

        return $this->userDataTransformer->populateDto($user);
    }

    public function validate(UserDto $userDto)
    {
        if (empty($token = $userDto->getToken())) {
            throw new BadRequestHttpException('Missing token');
        }

        /** @var $user User */
        if (empty($user = $this->userService->findByToken($token))) {
            throw new NotFoundHttpException('Token not found');
        }

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::ACTIVATE);

        $this->userService->save($user);
    }

    public function resetPassword(UserDto $userDto)
    {
        if (empty($userDto->getEmail())) {
            throw new BadRequestHttpException('missing email parameter');
        }

        /** @var $user User */
        if (!empty($user = $this->userService->findByEmail($userDto->getEmail()))) {
            $this->dispatcher->dispatch(new UserEvent($user), UserEvent::RESET_PASSWORD);

            $this->userService->save($user);
        }
    }

    public function newPassword(UserDto $userDto)
    {
        if (empty($token = $userDto->getToken()) || empty($password = $userDto->getPassword())) {
            throw new BadRequestHttpException('Missing parameter');
        }

        /** @var $user User */
        if (empty($user = $this->userService->findByToken($token))) {
            throw new NotFoundHttpException('Token not found');
        }

        $user->setPlainPassword($password);

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::NEW_PASSWORD);

        $this->userService->save($user);
    }
}