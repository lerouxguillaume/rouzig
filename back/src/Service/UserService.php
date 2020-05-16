<?php

namespace App\Service;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;

class UserService
{
    /** @var EntityManagerInterface */
    private $entityManager;

    /**
     * WordService constructor.
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function save(User $user)
    {
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function delete(User $user)
    {
        $user
            ->setDeletedAt(new \DateTime())
        ;
        $this->entityManager->persist($user);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?User
    {
        return $this->entityManager->find(User::class, $id);
    }

    public function findByEmail(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneByEmail($email);
    }

    public function findByUsername(string $email): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneByUsername($email);
    }

    public function findByToken(string $token): ?User
    {
        return $this->entityManager->getRepository(User::class)->findOneByToken($token);
    }
}