<?php

namespace App\Repository;

use App\Entity\Search;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;

class SearchRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Search::class);
    }

    public function findByCriteria(Criteria $criteria): array
    {
        return $this->createQueryBuilder('s')->addCriteria($criteria)->getQuery()->getResult();
    }

    public function countByCriteria(Criteria $criteria): int
    {
        $criteria->setMaxResults(null)->setFirstResult(null);
        return $this->createQueryBuilder('s')->select('count(s)')->addCriteria($criteria)->getQuery()->getSingleScalarResult();
    }
}