<?php

namespace App\Service;

use App\Entity\Search;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManagerInterface;

class SearchService
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

    public function save(Search $search)
    {
        $this->entityManager->persist($search);
        $this->entityManager->flush();
    }

    public function findByCriteria(Criteria $criteria): array
    {
        return $this->entityManager->getRepository(Search::class)->findByCriteria($criteria);
    }

    public function countByCriteria(Criteria $criteria): int
    {
        return $this->entityManager->getRepository(Search::class)->countByCriteria($criteria);
    }

    public function find(string $id): ?Search
    {
        return $this->entityManager->getRepository(Search::class)->find($id);
    }

    public function delete(string $id)
    {
        if (!empty($search = $this->find($id))) {
            $this->entityManager->remove($search);
            $this->entityManager->flush();
        }
    }
}