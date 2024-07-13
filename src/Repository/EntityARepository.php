<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\EntityA;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<EntityA>
 *
 * @method EntityA|null find($id, $lockMode = null, $lockVersion = null)
 * @method EntityA|null findOneBy(array $criteria, array $orderBy = null)
 * @method EntityA[]    findAll()
 * @method EntityA[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EntityARepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EntityA::class);
    }

    public function save(EntityA $entity): void
    {
        $this->getEntityManager()->persist($entity);
        $this->getEntityManager()->flush();
    }

    public function remove(EntityA $entity): void
    {
        $this->getEntityManager()->remove($entity);
        $this->getEntityManager()->flush();
    }
}
