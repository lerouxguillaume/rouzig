<?php

namespace App\Service;

use App\Entity\Search;
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

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Search::class)->findBy([], ['count' => 'DESC']);
    }

    public function find(string $id): ?Search
    {
        return $this->entityManager->getRepository(Search::class)->find($id);
    }
}