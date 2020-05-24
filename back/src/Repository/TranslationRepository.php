<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Translation;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;

class TranslationRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Translation::class);
    }

    public function findByCriteria(Criteria $criteria): array
    {
        return $this->createQueryBuilder('t')->addCriteria($criteria)->getQuery()->getResult();
    }

    public function countByCriteria(Criteria $criteria): int
    {
        $criteria->setMaxResults(null)->setFirstResult(null);
        return $this->createQueryBuilder('t')->select('count(t)')->addCriteria($criteria)->getQuery()->getSingleScalarResult();
    }
}