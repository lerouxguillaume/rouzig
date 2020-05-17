<?php

namespace App\Handler;

use App\Dto\UserDto;
use App\Entity\User;
use App\Event\UserEvent;
use App\Service\UserService;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class UserDtoHandler
{
    /** @var UserService */
    private $userService;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * UserDtoHandler constructor.
     * @param UserService $userService
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(UserService $userService, EventDispatcherInterface $dispatcher)
    {
        $this->userService = $userService;
        $this->dispatcher = $dispatcher;
    }

    public function create(UserDto $userDto)
    {
        $user = new User();
        $user->populateFromDto($userDto);

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::REGISTER);

        $this->userService->save($user);

        return $user->getDto();
    }

    public function update(int $id, UserDto $userDto)
    {
        $user = $this->userService->findById($id);

        $updatedUser = $user->populateFromDto($userDto);

        $this->userService->save($updatedUser);

        return $updatedUser->getDto();
    }

    public function delete(UserDto $userDto)
    {
        $user = $this->userService->findById($userDto->getId());

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::DELETE);

        $this->userService->delete($user);

        return $user->getDto();
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