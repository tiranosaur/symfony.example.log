<?php declare(strict_types=1);

namespace App\Tests\Controller;

use App\DataFixtures\ArticleFixtures;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ArticleControllerTest extends WebTestCase
{
    private $client;

    private $articleRepository;
    private $article;

    public function setUp(): void
    {
        $this->article = Article::create(10, 'Laura Harris', 'Tenth Article', 'This is the content of the tenth article.', 16.40);

        parent::setUp();

        $this->client = static::createClient();
        $this->articleRepository = $this->getContainer()->get(ArticleRepository::class);
        // clean up db
        $this->articleRepository->truncate();

        // seeding
        $objectManager = $this->getContainer()->get('doctrine.orm.entity_manager');
        $fixtures = new ArticleFixtures();
        $fixtures->load($objectManager);
//        $checkpoint = $this->checkpointRepository->findAll();
    }

    public function tearDown(): void
    {
        parent::tearDown();
        // clean up db
        // $this->checkpointRepository->truncate();
    }

    public function testDbFullness()
    {
        $this->assertEquals(10, count($this->articleRepository->findAll()));
    }

    public function testIndex(): void
    {
        $this->client->request('GET', '/article',);

//        $this->assertEquals(200, $this->client->getResponse()->getStatusCode());
        $this->assertResponseIsSuccessful();

        $content = $this->client->getResponse()->getContent();
        $this->assertSelectorTextContains('title', 'Article');
        $this->assertStringContainsString('<table id="article-table">', $content);
        $this->assertStringContainsString('<input type="text" id="article-form-id" name="article-form-id" disabled>', $content);
        $this->assertStringContainsString('<input type="text" id="article-form-title" name="article-form-title">', $content);
    }

    public function testList(): void
    {
        $this->client->request('GET', '/article/all',);

        $this->assertResponseIsSuccessful();

        $content = $this->client->getResponse()->getContent();
        $data = json_decode($content, true);

        $this->assertCount(10, $data);
        $this->assertJsonStringEqualsJsonString(json_encode($this->article), json_encode($data[0]));
    }

    public function testRead(): void
    {
        $this->client->request('GET', '/article/10',);

        $this->assertResponseIsSuccessful();

        $content = $this->client->getResponse()->getContent();
        $this->assertJsonStringEqualsJsonString(json_encode($this->article), $content);
    }

    public function testCreate(): void
    {
        $article = Article::create(null, 'Xxx author', 'XXX Article', 'This is the content of the XXX article.', 99.40);

        $this->client->request('POST', '/article', [], [], [], json_encode($article));

        $this->assertResponseIsSuccessful();

        $result = $this->articleRepository->findOneBy(['title' => 'XXX Article']);
        $this->assertNotNull($result);
        $this->assertEquals(11, $result->getId());
        $this->assertEquals($result->getAuthor(), $article->getAuthor());
        $this->assertEquals($result->getTitle(), $article->getTitle());
        $this->assertEquals($result->getContent(), $article->getContent());
        $this->assertEquals($result->getPrice(), $article->getPrice());
        $this->assertEquals(11, count($this->articleRepository->findAll()));
    }

    public function testUpdate(): void
    {
        $article = Article::create(1, 'YYY author', 'YYY Article', 'This is the content of the YYY article.', 1.1);

        $this->client->request('PUT', '/article/1', [], [], [], json_encode($article));

        $this->assertResponseIsSuccessful();

        $result = $this->articleRepository->findOneBy(['title' => 'YYY Article']);
        $this->assertNotNull($result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals($result->getAuthor(), $article->getAuthor());
        $this->assertEquals($result->getTitle(), $article->getTitle());
        $this->assertEquals($result->getContent(), $article->getContent());
        $this->assertEquals($result->getPrice(), $article->getPrice());
        $this->assertEquals(10, count($this->articleRepository->findAll()));
    }

    public function testDelete(): void
    {
        $this->client->request('DELETE', '/article/1');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(null, $this->articleRepository->findOneBy(['id' => 1]));
        $this->assertEquals(9, count($this->articleRepository->findAll()));
    }
}
