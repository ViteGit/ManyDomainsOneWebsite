<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\NonUniqueResultException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Category::class);
    }

    /**
     * @param int $id
     *
     * @return Category | null
     *
     * @throws EntityNotFoundException
     */
    public function getCategoryById(int $id)
    {
        $category = $this->findOneBy(['id' => $id]);

        if (empty($category)) {
            throw new EntityNotFoundException("Пост с id = $id не найден");
        }

        return $category;
    }

    /**
     * @param string $slug
     *
     * @return Category | null
     *
     * @throws EntityNotFoundException
     */
    public function getCategoryByName(string $slug)
    {
        $category = $this->findOneBy(['slug' => $slug]);

        if (empty($category)) {
            throw new NotFoundHttpException("Страница не найдена");
        }

        return $category;
    }

    /**
     * @param bool  $active
     *
     * @return int
     *
     * @throws NonUniqueResultException
     */
    public function getFilteredLinesCount(
    ): int {
        $builder = $this->getFilteredLinesQuery(
            $this->getEntityManager()
                ->createQueryBuilder()
                ->select('COUNT(c)')
                ->from(Category::class, 'c')
        );

        $result = $builder->getQuery()->getSingleScalarResult();

        return $result ?? 0;
    }

    /**
     * @param QueryBuilder $builder
     * @param bool $active
     * @return QueryBuilder
     */
    private function getFilteredLinesQuery(
        QueryBuilder $builder
    ): QueryBuilder {
        $builder->andWhere('c.active = true');

        return $builder;
    }

    /**
     * @return array
     */
    public function findAllActive(): array {
        return $this->createQueryBuilder('c')
            ->andWhere('c.active = true')
            ->getQuery()
            ->getResult();
    }


    /**
     * @return array
     */
    public function findOnMainPage(): array {
        return $this->createQueryBuilder('c')
            ->andWhere('c.onMainPage = true')
            ->getQuery()
            ->getResult();
    }

    /**
     * @param int $limit
     * @param int $offset
     * @param string $sortBy
     * @param string $order
     *
     * @return array
     */
    public function findWithVideoNumbers(int $limit, int $offset, string $sortBy = 'id', string $order = 'ASC'): array
    {
        return $this->createQueryBuilder('c')
            ->select('c as entity', 'count(c) as videoTotal')
            ->innerJoin('c.videos', 'v')
            ->andWhere('c.active = true')
            ->andWhere('v.active = true')
            ->orderBy("c.$sortBy", $order)
            ->setFirstResult($offset)
            ->setMaxResults($limit)
            ->groupBy('c.id')
            ->getQuery()
            ->getResult();
    }
}
