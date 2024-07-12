<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'title' => 'Main Page',
            'data' => [
                $this->generateUrl('app_form_controller') => 'создание формы в контроллере',
                $this->generateUrl('app_form_class') => 'создание формы в классе'
            ]
        ]);
    }
}
