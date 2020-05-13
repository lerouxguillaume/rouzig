<?php

namespace App\Service;

use App\Entity\Example;
use App\Entity\Translation;
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

    public function update(int $id, WordObject $wordObject) : WordObject
    {
        /** @var WordObject $oldWordObject */
        $oldWordObject = $this->entityManager->getRepository(WordObject::class)->find($id);

        $oldWordObject
            ->setText($wordObject->getText())
            ->setDescription($wordObject->getDescription())
            ->setLanguage($wordObject->getLanguage())
            ->setAuthor($wordObject->getAuthor())
        ;

        $updatedTranslations = [];

        /** @var Translation $translation */
        foreach ($wordObject->getTranslations() as $translation) {
            if ($translation->getId() &&
                ($oldTranslation = $oldWordObject->getTranslationById($translation->getId()))
            ) {
                $translation = $this->updateTranslation($translation, $oldTranslation);
            }
            $updatedTranslations[] = $translation;
        }

        $oldWordObject->setTranslations($updatedTranslations);

        $this->entityManager->persist($oldWordObject);
        $this->entityManager->flush();

        return $oldWordObject;
    }

    private function updateTranslation(Translation $newTranslation, Translation $oldTranslation) : Translation
    {
        $oldTranslation
            ->setText($newTranslation->getText())
            ->setLanguage($newTranslation->getLanguage())
            ->setDescription($newTranslation->getDescription())
        ;

        $updatedExamples = [];

        /** @var Example $example */
        foreach ($newTranslation->getExamples() as $example) {
            if ($example->getId() &&
                ($oldExample = $oldTranslation->getExampleById($example->getId()))
            ) {
                $example = $this->updateExample($example, $oldExample);
            }
            $updatedExamples[] = $example;
        }
        $oldTranslation->setExamples($updatedExamples);

        return $oldTranslation;
    }

    private function updateExample(Example $newExample, Example $oldExample) : Example
    {
        $oldExample
            ->setToText($newExample->getToText())
            ->setFromText($newExample->getFromText())
        ;

        return $oldExample;
    }

    public function delete(WordObject $wordObject)
    {
        $wordObject->setDeletedAt(new \DateTime());
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