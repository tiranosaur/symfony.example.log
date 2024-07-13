<?php

namespace App\Repository;

use App\Entity\EntityB;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntityB>
 *
 * @method EntityB|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityB|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityB[]    findAll()
 * @method EntityB[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityBRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityB::class);
    }

    public function save(?EntityB $entityB): void
    {
        $this->getEntityManager()->persist($entityB);
        $this->getEntityManager()->flush();
    }
}
