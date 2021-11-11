<?php

namespace App\Repository\Moderation;

use App\Entity\Moderation\Kick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Kick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Kick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Kick[]    findAll()
 * @method Kick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class KickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Kick::class);
    }

    public function findAllDesc()
    {
        return $this->createQueryBuilder('k')
            ->orderBy('k.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function save($kick)
    {
        $this->_em->persist($kick);
        $this->_em->flush();
    }

    public function update($kick)
    {
        $this->_em->flush();
    }

    public function remove($kick)
    {
        $this->_em->remove($kick);
        $this->_em->flush();
    }
}
