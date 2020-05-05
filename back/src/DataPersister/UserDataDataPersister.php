<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use App\Event\UserEvent;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var EntityManagerInterface */
    private $em;

    /** @var EventDispatcherInterface */
    private $dispatcher;

    /**
     * UserDataDataPersister constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $dispatcher
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $entityManager;
        $this->dispatcher = $dispatcher;
    }

    public function supports($data, array $context = []): bool
    {
        return $data instanceof User;
    }

    public function persist($data, array $context = [])
    {
        /** @var User $user */
        $user = $data;
        $user->setIsActive(true);

        $password = $this->passwordEncoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

//        $this->em->persist($user);
//        $this->em->flush();

        $this->dispatcher->dispatch(new UserEvent($user), UserEvent::REGISTER);

        return $user;
    }

    public function remove($data, array $context = [])
    {
        return;
    }
}