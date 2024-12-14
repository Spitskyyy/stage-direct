<?php

namespace App\Repository;

use App\Entity\Stage;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Stage>
 */
class StageRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Stage::class);
    }

    public function findBySearchAndSort(string $searchTerm, string $sort, string $order): array
    {
        $qb = $this->createQueryBuilder('s');
    
        // Recherche
        if ($searchTerm) {
            $qb->where('s.name LIKE :searchTerm')
                ->orWhere('s.address LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }
    
        // Tri
        if (in_array($sort, ['id', 'name', 'address', 'start_date', 'end_date']) && in_array($order, ['asc', 'desc'])) {
            $qb->orderBy('s.' . $sort, $order);
        }
    
        return $qb->getQuery()->getResult();
    }
    

    //    /**
    //     * @return Stage[] Returns an array of Stage objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('s.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Stage
    //    {
    //        return $this->createQueryBuilder('s')
    //            ->andWhere('s.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
