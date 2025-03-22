<?php
namespace Application\Repository;

use Application\Entity\Produkt;
use Doctrine\ORM\EntityRepository;

class ProduktRepository extends EntityRepository
{
    public function findAllPaginated($page = 1, $limit = 10, $orderBy = 'id', $orderDir = 'ASC', $filters = [])
    {
        $qb = $this->createQueryBuilder('p')
            ->select('p, z, m')
            ->join('p.znacka', 'z')
            ->join('p.material', 'm');
        
        if (!empty($filters['znacka_id'])) {
            $qb->andWhere('p.znacka = :znacka')
               ->setParameter('znacka', $filters['znacka_id']);
        }
        
        if (!empty($filters['material_id'])) {
            $qb->andWhere('p.material = :material')
               ->setParameter('material', $filters['material_id']);
        }
        
        if (!empty($filters['search'])) {
            $qb->andWhere('p.kod LIKE :search OR p.popis LIKE :search')
               ->setParameter('search', '%' . $filters['search'] . '%');
        }

        $qb->orderBy('p.' . $orderBy, $orderDir);
        
        $qb->setFirstResult(($page - 1) * $limit)
           ->setMaxResults($limit);
        
        return $qb->getQuery()->getResult();
    }
    
    public function countAll($filters = [])
    {
        $qb = $this->createQueryBuilder('p')
            ->select('COUNT(p.id)');
        
        if (!empty($filters['znacka_id'])) {
            $qb->andWhere('p.znacka = :znacka')
               ->setParameter('znacka', $filters['znacka_id']);
        }
        
        if (!empty($filters['material_id'])) {
            $qb->andWhere('p.material = :material')
               ->setParameter('material', $filters['material_id']);
        }
        
        if (!empty($filters['search'])) {
            $qb->andWhere('p.kod LIKE :search OR p.popis LIKE :search')
               ->setParameter('search', '%' . $filters['search'] . '%');
        }
        
        return $qb->getQuery()->getSingleScalarResult();
    }
}
