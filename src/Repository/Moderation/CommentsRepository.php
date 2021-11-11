<?php

namespace App\Repository\Moderation;

use App\Entity\Moderation\Comments;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Comments|null find($id, $lockMode = null, $lockVersion = null)
 * @method Comments|null findOneBy(array $criteria, array $orderBy = null)
 * @method Comments[]    findAll()
 * @method Comments[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CommentsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Comments::class);
    }

    public function findAllDesc()
    {
        return $this->createQueryBuilder('c')
            ->orderBy('c.id', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }

    public function save($comments): void
    {
        $this->_em->persist($comments);
        $this->_em->flush();
    }

    public function update($comments): void
    {
        $this->_em->flush();
    }

    public function remove($comments): void
    {
        $this->_em->remove($comments);
        $this->_em->flush();
    }
}
