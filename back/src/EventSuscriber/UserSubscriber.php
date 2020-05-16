<?php

namespace App\EventSuscriber;

use App\Event\UserEvent;
use App\Service\MailService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /** @var EntityManagerInterface */
    private $em;

    /** @var MailService */
    private $mailService;

    /** @var string */
    private $redirectUrl;

    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /**
     * UserSubscriber constructor.
     * @param EntityManagerInterface $em
     * @param MailService $mailService
     * @param string $redirectUrl
     * @param UserPasswordEncoderInterface $passwordEncoder
     */
    public function __construct(EntityManagerInterface $em, MailService $mailService, string $redirectUrl, UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->em = $em;
        $this->mailService = $mailService;
        $this->redirectUrl = $redirectUrl;
        $this->passwordEncoder = $passwordEncoder;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserEvent::REGISTER => ['onUserRegister'],
            UserEvent::ACTIVATE => ['onUserActivate'],
            UserEvent::DISABLE => ['onUserDisable'],
            UserEvent::DELETE => ['onUserDelete'],
            UserEvent::RESET_PASSWORD => ['onUserResetPassword'],
            UserEvent::NEW_PASSWORD => ['onUserNewPassword'],
        ];
    }

    public function onUserRegister(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setIsActive(true);

        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user
            ->setPassword($password)
            ->setPlainPassword(null)
            ->setIsActive(false)
        ;

        $user->setToken($this->generateToken());

        $this->em->persist($user);
        $this->em->flush();

        $this->mailService->sendEmailValidation($event->getUser(), $this->redirectUrl);
    }

    public function onUserActivate(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setIsActive(true);
        $user->setToken(null);
    }

    public function onUserDisable(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setIsActive(false);
    }

    public function onUserDelete(UserEvent $event)
    {
        $user = $event->getUser();

        $user->setIsActive(false);
        $user->setDeletedAt(new \DateTime());
    }

    public function onUserResetPassword(UserEvent $event)
    {
        $user = $event->getUser();

        if (empty($user->getToken())) {
            $user->setToken($this->generateToken());
        }

        $this->mailService->sendEmailResetPassword($event->getUser(), $this->redirectUrl);
    }

    public function onUserNewPassword(UserEvent $event)
    {
        $user = $event->getUser();

        $password = $this->passwordEncoder->encodePassword($user, $user->getPlainPassword());
        $user
            ->setPassword($password)
            ->setToken(null)
            ->setPlainPassword(null)
        ;
    }

    private function generateToken(): string
    {
        return sha1(random_bytes(24));
    }
}