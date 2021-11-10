<?php

namespace App\Repository\Moderation;

use App\Entity\Moderation\Mute;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Mute|null find($id, $lockMode = null, $lockVersion = null)
 * @method Mute|null findOneBy(array $criteria, array $orderBy = null)
 * @method Mute[]    findAll()
 * @method Mute[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class MuteRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Mute::class);
    }

    public function findAllDesc()
    {
        return $this->createQueryBuilder('m')
            ->orderBy('m.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function save($mute)
    {
        $this->_em->persist($mute);
        $this->_em->flush();
    }

    public function update($mute)
    {
        $this->_em->flush();
    }

    public function remove($mute)
    {
        $this->_em->remove($mute);
        $this->_em->flush();
    }
}
