<?php


namespace App\DataPersister;


use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserDataDataPersister implements ContextAwareDataPersisterInterface
{
    /** @var UserPasswordEncoderInterface */
    private $passwordEncoder;

    /** @var EntityManagerInterface */
    private $em;

    /**
     * UserDataDataPersister constructor.
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(
        UserPasswordEncoderInterface $passwordEncoder,
        EntityManagerInterface $entityManager
    )
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->em = $entityManager;
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

        $this->em->persist($user);
        $this->em->flush();

        return $user;
    }

    public function remove($data, array $context = [])
    {
        return;
    }
}