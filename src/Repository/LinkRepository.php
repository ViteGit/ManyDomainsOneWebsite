<?php

namespace App\Repository;

use App\Entity\Link;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Link|null find($id, $lockMode = null, $lockVersion = null)
 * @method Link|null findOneBy(array $criteria, array $orderBy = null)
 * @method Link[]    findAll()
 * @method Link[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class LinkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Link::class);
    }

    /**
     * @param string $id
     *
     * @return Link[]
     */
    public function findBySiteId(string $id)
    {
        return $this->createQueryBuilder('l')
        ->innerJoin('l.site','s')
        ->andWhere('s.id = :id')
        ->setParameter(':id', $id)
        ->getQuery()
        ->getResult();
    }
}
