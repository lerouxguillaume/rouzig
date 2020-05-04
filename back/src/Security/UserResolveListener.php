<?php

namespace App\Security;

use App\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Trikoder\Bundle\OAuth2Bundle\Event\UserResolveEvent;

final class UserResolveListener
{
    /**
     * @var UserRepository
     */
    private $userProvider;

    /**
     * @var UserPasswordEncoderInterface
     */
    private $userPasswordEncoder;

    /**
     * @param UserRepository $userProvider
     * @param UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserRepository $userProvider, UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userProvider = $userProvider;
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param UserResolveEvent $event
     */
    public function onUserResolve(UserResolveEvent $event): void
    {
        $user = $this->userProvider->loadUserByUsername($event->getUsername());

        if (null === $user) {
            return;
        }

        if (!$this->userPasswordEncoder->isPasswordValid($user, $event->getPassword())) {
            return;
        }

        $event->setUser($user);
    }
}