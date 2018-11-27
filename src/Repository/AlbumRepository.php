<?php

namespace App\Repository;

use App\Entity\Album;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Album|null find($id, $lockMode = null, $lockVersion = null)
 * @method Album|null findOneBy(array $criteria, array $orderBy = null)
 * @method Album[]    findAll()
 * @method Album[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AlbumRepository extends ServiceEntityRepository
{
    /**
     * AlbumRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Album::class);
    }

    /**
     * @return mixed
     */
    public function findThreeForHome()
    {
        return $this->createQueryBuilder('a')
            ->orderBy('a.createAt', 'DESC')
            ->setMaxResults(3)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param $category
     * @return mixed
     */
    public function findAllAlbumsByFilters($category)
    {
        $qb = $this->createQueryBuilder('a')
            ->select('a');

        if ($category !== 'all') {
            $qb->leftJoin('a.category', 'ac')
                ->andWhere('ac.name = :cat')
                ->setParameter('cat', $category);
        }

        return $qb->getQuery()->getResult();
    }
}
