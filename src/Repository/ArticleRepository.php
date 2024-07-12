<?php declare(strict_types=1);

namespace App\Repository;

use App\Entity\Article;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Article>
 *
 * @method Article|null find($id, $lockMode = null, $lockVersion = null)
 * @method Article|null findOneBy(array $criteria, array $orderBy = null)
 * @method Article[]    findAll()
 * @method Article[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ArticleRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Article::class);
    }

    public function getList($limit)
    {
        $result = $this->getEntityManager()
            ->createQuery('SELECT e FROM App\Entity\Article e ORDER BY e.id DESC')
            ->setMaxResults($limit)
            ->getResult();

        return $result;

        $result = $this->createQueryBuilder('e')
            ->orderBy('e.id', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();
    }

    public function get(int $id): Article
    {
        $result1 = $this->getEntityManager()->getRepository(Article::class)->find($id);

        return $result1;

        $result2 = $this->getEntityManager()
            ->createQuery('SELECT e FROM App\Entity\Article e WHERE e.id = :id')
            ->setParameter('id', $id)
            ->getSingleResult();

        $result3 = $this->createQueryBuilder('e')
            ->andWhere('e.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getOneOrNullResult();


    }

    public function create(Article $article): void
    {
        $entityManager = $this->getEntityManager();
        $entityManager->persist($article);
        $entityManager->flush();
    }

    public function update(int $id, array $data): void
    {
        $article = $this->get($id);
        $article->setTitle($data['title']);
        $article->setAuthor($data['author']);
        $article->setContent($data['content']);
        $article->setPrice(floatval($data['price']));
        $this->getEntityManager()->flush();
    }

    public function delete(int $id): void
    {
        $article = $this->getEntityManager()->getRepository(Article::class)->find($id);
        if ($article) {
            $this->getEntityManager()->remove($article);
            $this->getEntityManager()->flush();
        }
        return;

        $this->getEntityManager()
            ->createQueryBuilder()
            ->delete(Article::class, 'a')
            ->where('a.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->execute();
    }

    public function truncate(): void
    {
        $tableName = 'article';
        $connection = $this->getEntityManager()->getConnection();
        $platform = $connection->getDatabasePlatform();

        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=0;');
        $connection->executeStatement($platform->getTruncateTableSQL($tableName, true /* whether to reset auto-increment */));
        $connection->executeStatement('SET FOREIGN_KEY_CHECKS=1;');
    }
}