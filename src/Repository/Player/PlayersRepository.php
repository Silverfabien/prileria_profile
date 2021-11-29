<?php

namespace App\Repository\Player;

use App\Entity\Player\Players;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Players|null find($id, $lockMode = null, $lockVersion = null)
 * @method Players|null findOneBy(array $criteria, array $orderBy = null)
 * @method Players[]    findAll()
 * @method Players[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayersRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Players::class);
    }

    public function findAllDesc()
    {
        return $this->createQueryBuilder('p')
            ->orderBy('p.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function searchByPseudo($search) {
        return $this->createQueryBuilder('p')
            ->where('p.batPlayer LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }

    public function searchByIp($search) {
        return $this->createQueryBuilder('p')
            ->where('p.lastip LIKE :search')
            ->setParameter('search', '%'.$search.'%')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult();
    }
}
