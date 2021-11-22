<?php

namespace App\Repository\Player;

use App\Entity\Player\Locked;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Locked|null find($id, $lockMode = null, $lockVersion = null)
 * @method Locked|null findOneBy(array $criteria, array $orderBy = null)
 * @method Locked[]    findAll()
 * @method Locked[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LockedRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Locked::class);
    }

    public function save($locked)
    {
        $this->_em->persist($locked);
        $this->_em->flush();
    }

    public function update($locked)
    {
        $this->_em->flush();
    }

    public function remove($locked)
    {
        $this->_em->remove($locked);
        $this->_em->flush();
    }
}
