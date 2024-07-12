<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticleController extends AbstractController
{
    #[Route('/article', name: 'article_index', methods: ['GET'])]
    public function index(Request $request, ArticleService $articleService): Response
    {
        return $this->render('article/index.html.twig', [
            'title' => 'Article',
        ]);
    }

    #[Route('/article/all', name: 'article_list', methods: ['GET'])]
    public function list(Request $request, ArticleService $articleService): JsonResponse
    {
        return $this->json($articleService->list());
    }

    #[Route('/article/{id}', name: 'article_read', methods: ['GET'])]
    public function read(int $id, Request $request, ArticleService $articleService): JsonResponse
    {
        return $this->json($articleService->get($id));
    }

    #[Route('/article', name: 'article_create', methods: ['POST'])]
    public function create(Request $request, ArticleService $articleService): JsonResponse
    {
        $articleService->create(json_decode($request->getContent(), true));
        return $this->json(null, Response::HTTP_CREATED);
    }

    #[Route('/article/{id}', name: 'article_update', methods: ['PUT'])]
    public function update(int $id, Request $request, ArticleService $articleService): JsonResponse
    {
        $articleService->update($id, json_decode($request->getContent(), true));
        return $this->json(null, Response::HTTP_ACCEPTED);
    }

    #[Route('/article/{id}', name: 'article_delete', methods: ['DELETE'])]
    public function delete(int $id, Request $request, ArticleService $articleService): JsonResponse
    {
        $articleService->delete($id);
        return $this->json(null, Response::HTTP_ACCEPTED);
    }
}
