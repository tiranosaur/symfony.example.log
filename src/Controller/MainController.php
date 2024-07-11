<?php declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/main', name: 'main_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'title' => 'MainController',
            'data' => [
                'test' => 'hello'
            ]
        ]);
    }
}
