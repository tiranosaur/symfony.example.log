<?php declare(strict_types=1);

namespace App\Service;

use App\Entity\Article;
use App\Repository\ArticleRepository;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleService
{
    const LIMIT = 10;
    private ArticleRepository $articleRepository;

    function __construct(ArticleRepository $articleRepository)
    {
        $this->articleRepository = $articleRepository;
    }

    public function list(): array
    {
        return $this->articleRepository->getList(self::LIMIT);
    }

    public function get(int $id): Article
    {
        return $this->articleRepository->get($id);
    }

    public function create(array $data): void
    {
        $article = Article::create(null, $data['author'], $data['title'], $data['content'], floatval($data['price']),);
        $this->articleRepository->create($article);
    }

    public function update(int $id, array $data): void
    {
        if ($id != intval($data['id'])) {
            throw new NotFoundHttpException("wrong id");
        }
        $this->articleRepository->update($id, $data);
    }

    public function delete(int $id): void
    {
        $this->articleRepository->delete($id);
    }
}