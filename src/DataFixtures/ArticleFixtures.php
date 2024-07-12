<?php declare(strict_types=1);

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $arr = [
            Article::create(null, null, 'First Article', 'This is the content of the first article.', 0.02),
            Article::create(null, 'Jane Smith', 'Second Article', 'This is the content of the second article.', 15.75),
            Article::create(null, 'Emily Johnson', 'Third Article', 'This is the content of the third article.', 12.30),
            Article::create(null, 'Michael Brown', 'Fourth Article', 'This is the content of the fourth article.', 8.99),
            Article::create(null, 'Jessica Davis', 'Fifth Article', 'This is the content of the fifth article.', 20.00),
            Article::create(null, 'David Wilson', 'Sixth Article', 'This is the content of the sixth article.', 18.50),
            Article::create(null, 'Sarah Lee', 'Seventh Article', 'This is the content of the seventh article.', 11.25),
            Article::create(null, 'Christopher Martinez', 'Eighth Article', 'This is the content of the eighth article.', 14.00),
            Article::create(null, 'Daniel White', 'Ninth Article', 'This is the content of the ninth article.', 9.75),
            Article::create(null, 'Laura Harris', 'Tenth Article', 'This is the content of the tenth article.', 16.40),
        ];

        foreach ($arr as $article) {
            $manager->persist($article);
        }

        $manager->flush();
    }

}
