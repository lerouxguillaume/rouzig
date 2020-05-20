<?php

namespace App\Service;

use App\Entity\WordObject;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class WordService
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

    public function findByCriteria(Criteria $criteria): array
    {
        return $this->entityManager->getRepository(WordObject::class)->findByCriteria($criteria);
    }

    public function countByCriteria(Criteria $criteria): int
    {
        return $this->entityManager->getRepository(WordObject::class)->countByCriteria($criteria);
    }

    public function find(string $id): ?WordObject
    {
        return $this->entityManager->getRepository(WordObject::class)->find($id);
    }
}