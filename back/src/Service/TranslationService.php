<?php

namespace App\Service;

use App\Entity\Translation;
use App\Entity\WordObject;
use Doctrine\ORM\EntityManagerInterface;

class TranslationService
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

    public function save(Translation $translation)
    {
        $this->entityManager->persist($translation);
        $this->entityManager->flush();
    }

    public function delete(Translation $translation)
    {
        $translation
            ->setDeletedAt(new \DateTime())
        ;
        $this->entityManager->persist($translation);
        $this->entityManager->flush();
    }

    public function findById(int $id): ?Translation
    {
        return $this->entityManager->find(Translation::class, $id);
    }

    public function findByStatus(string $status): array
    {
        return $this->entityManager->getRepository(Translation::class)->findByStatus($status);
    }
}