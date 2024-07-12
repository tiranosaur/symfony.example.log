<?php

namespace App\Controller;

use App\Service\MainService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(MainService $mainService): Response
    {
        return $this->render('main/index.html.twig', [
            'title' => 'Main Page',
            'message' => $mainService->getMessage(),
            'data' => [
            ]
        ]);
    }
}
