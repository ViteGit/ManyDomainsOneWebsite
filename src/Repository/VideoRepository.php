<?php

namespace App\Repository;

use App\Entity\Video;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\NonUniqueResultException;

/**
 * @method Video|null find($id, $lockMode = null, $lockVersion = null)
 * @method Video|null findOneBy(array $criteria, array $orderBy = null)
 * @method Video[]    findAll()
 * @method Video[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class VideoRepository extends ServiceEntityRepository
{
    /**
     * @param ManagerRegistry $registry
     */
    public function __construct(ManagerRegistry $registry)
    {

        parent::__construct($registry, Video::class);
    }

    /**
     * @param int $id
     *
     * @return Video
     *
     * @throws EntityNotFoundException
     */
    public function getById(int $id): Video
    {
        $video = $this->findOneBy(['id' => $id]);

        if (empty($video)) {
            throw new EntityNotFoundException("Пост с id = $id не найден");
        }

        return $video;
    }

    /**
     * @param int|null $limit
     * @param int|null $offset
     *
     * @return mixed
     */
    public function getRandomVideos(?int $limit = 15, ?int $offset = null)
    {
        $builder = $this->createQueryBuilder('v')
            ->andWhere('v.active = 1')
            ->orderBy('RAND()')
            ->setMaxResults($limit);

        if (!empty($offset)) {
            $builder->setFirstResult($offset);
        }

        return $builder
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int | null $limit
     * @param int | null $offset
     * @param array $categoryIds
     * @param string $sort
     * @param string $order
     * @param string $query
     * @return array | Video[]
     */
    public function findByFilters(
        ?int $limit = null,
        ?int $offset = null,
        array $categoryIds = [],
        $sort = 'id',
        $order = 'ASC',
        ?string $query = null
    ) {
        $builder = $this->getFilteredLinesQuery(
            $this->createQueryBuilder('v'),
            $categoryIds,
            $query
        );

        if (!empty($offset)) {
            $builder->setFirstResult($offset);
        }

        if (!empty($limit)) {
            $builder->setMaxResults($limit);
        }

        $builder->orderBy("v.$sort", $order);

        return $builder->getQuery()->getResult();
    }

    /**
     * @param array $categoryIds
     * @param string|null $query
     * @return int
     *
     * @throws NonUniqueResultException
     * @throws \Doctrine\ORM\NoResultException
     */
    public function getFilteredLinesCount(
        array $categoryIds = [],
        ?string $query = null
    ): int {
        $builder = $this->getFilteredLinesQuery(
            $this->getEntityManager()
                ->createQueryBuilder()
                ->select('COUNT(v)')
                ->from(Video::class, 'v'),
            $categoryIds,
            $query
        );

        $result = $builder->getQuery()->getSingleScalarResult();

        return $result ?? 0;
    }

    /**
     * @param QueryBuilder $builder
     * @param array $categoryIds
     * @param string|null $query
     * @return QueryBuilder
     */
    private function getFilteredLinesQuery(
        QueryBuilder $builder,
        array $categoryIds = [],
        ?string $query = null
    ): QueryBuilder {
        if (!empty($query)) {
            $builder->andWhere('v.titleRu LIKE :query')
                ->setParameter(':query', "%$query%");
        }

        if (!empty($categoryIds)) {
            $builder->leftJoin('v.categories', 'c')
                ->andWhere('c.id in (:categoryIds)')
                ->setParameter(':categoryIds', $categoryIds);
        }

        $builder->andWhere('v.active = :active')
            ->setParameter('active', true);

        return $builder;
    }

    /**
     * @return array
     */
    public function findAllActive(): array
    {
        return $this->createQueryBuilder('v')
            ->andWhere('v.active = true')
            ->andWhere('v.slug IS NOT NULL')
            ->getQuery()
            ->getResult();
    }
}
