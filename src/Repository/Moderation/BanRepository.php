<?php

namespace App\Repository\Moderation;

use App\Entity\Moderation\Ban;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Ban|null find($id, $lockMode = null, $lockVersion = null)
 * @method Ban|null findOneBy(array $criteria, array $orderBy = null)
 * @method Ban[]    findAll()
 * @method Ban[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class BanRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Ban::class);
    }

    public function findAllDesc()
    {
        return $this->createQueryBuilder('b')
            ->orderBy('b.id', 'DESC')
            ->getQuery()
            ->getResult()
        ;
    }
}
