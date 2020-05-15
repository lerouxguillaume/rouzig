<?php

namespace App\Service;

use App\Entity\WordObject;
use Doctrine\ORM\EntityManagerInterface;

class WordService implements WordServiceInterface
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

    public function save(WordObject $wordObject)
    {
        $this->entityManager->persist($wordObject);
        $this->entityManager->flush();
    }

    public function delete(WordObject $wordObject)
    {
        $wordObject
            ->setDeletedAt(new \DateTime())
        ;
        $this->entityManager->persist($wordObject);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?WordObject
    {
        return $this->entityManager->find(WordObject::class, $id);
    }

    public function findByStatus(string $status): array
    {
        return $this->entityManager->getRepository(WordObject::class)->findByStatus($status);
    }

    public function search(string $search): array
    {
        return $this->entityManager->getRepository(WordObject::class)->findByText($search);
    }
}