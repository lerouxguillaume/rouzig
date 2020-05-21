<?php

namespace App\Service;

use App\Entity\WordObject;
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

    public function findByCriteria(string $text, string $type, $genre): array
    {
        return $this->entityManager->getRepository(WordObject::class)->findByCriteria($text,$type, $genre);
    }

    public function find(string $id): ?WordObject
    {
        return $this->entityManager->getRepository(WordObject::class)->find($id);
    }

    public function search(string $search): array
    {
        return $this->entityManager->getRepository(WordObject::class)->findByText($search);
    }
}