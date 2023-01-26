<?php

namespace App\Repository;

use App\Entity\Trick;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Trick>
 *
 * @method Trick|null find($id, $lockMode = null, $lockVersion = null)
 * @method Trick|null findOneBy(array $criteria, array $orderBy = null)
 * @method Trick[]    findAll()
 * @method Trick[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class TrickRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Trick::class);

        date_default_timezone_set('Europe/Paris');
        $this->currentDate = new \DateTime();
    }

    public function save(Trick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Trick $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function getTricks()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->where('t.deleted = :deleted')
            ->setParameter('deleted', 0);
        return $queryBuilder->getQuery()->getResult();
    }

    public function getPublishedTricks()
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->where('t.published = :published')
            ->andWhere('t.deleted = :deleted')
            ->setParameter('published', 1)
            ->setParameter('deleted', 0);
        return $queryBuilder->getQuery()->getResult();
    }

    public function getTrick($slug)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->where('t.slug = :slug')
            ->andWhere('t.deleted = :deleted')
            ->setParameter('slug', $slug)
            ->setParameter('deleted', 0);
        return $queryBuilder->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }

    public function getPublishedTrick($slug)
    {
        $queryBuilder = $this->createQueryBuilder('t')
            ->where('t.slug = :slug')
            ->andWhere('t.published = :published')
            ->andWhere('t.deleted = :deleted')
            ->setParameter('slug', $slug)
            ->setParameter('published', 1)
            ->setParameter('deleted', 0);
        return $queryBuilder->getQuery()->setMaxResults(1)->getOneOrNullResult();
    }
}
