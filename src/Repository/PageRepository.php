<?php

namespace App\Repository;

use App\Entity\Page;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @method Page|null find($id, $lockMode = null, $lockVersion = null)
 * @method Page|null findOneBy(array $criteria, array $orderBy = null)
 * @method Page[]    findAll()
 * @method Page[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Page::class);
    }

    /**
     * @param string $descriminator
     *
     * @return Page
     *
     * @throws EntityNotFoundException
     */
    public function getByDescriminator(string $descriminator): Page
    {
        if (empty($page = $this->findOneBy(['descriminator.value' => $descriminator]))) {
            throw new EntityNotFoundException('Страница не найдена');
        }

        return $page;
    }
}
