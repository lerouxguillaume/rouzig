<?php

namespace App\Repository;

use App\Entity\Search;
use App\Entity\Word\Adjective;
use App\Entity\Word\Adverb;
use App\Entity\Word\Conjunction;
use App\Entity\Word\Noun;
use App\Entity\Word\Other;
use App\Entity\Word\Preposition;
use App\Entity\Word\Pronoun;
use App\Entity\Word\Verb;
use App\Entity\WordObject;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;

class WordRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, WordObject::class);
    }

    public function findByCriteria(string $text, string $type, $genre): array
    {
        $qb = $this->createQueryBuilder('w');
        $qb
            ->from($type, 't')
            ->andWhere($qb->expr()->eq('t.text', ':text'))
            ->setParameter(':text', $text)
        ;

        if (in_array($type, [Noun::class, Pronoun::class, Adjective::class])) {
            if (!empty($genre)) {
                $qb
                    ->andWhere($qb->expr()->eq('t.genre', ':genre'))
                    ->setParameter(':genre', $genre);
            }
        }

        return $qb->getQuery()->getResult();
    }

}