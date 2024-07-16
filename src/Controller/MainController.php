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
                $this->generateUrl('app_user_register') => 'registration',
                $this->generateUrl('app_main_home') => 'home',
                $this->generateUrl('app_main_hello') => 'hello',
            ]
        ]);
    }

    #[Route('/home', name: 'app_main_home')]
    public function home(): Response
    {
        return $this->render('main/home.html.twig', [
            'title' => 'HOME page',
            'data' => [

            ]
        ]);
    }

    #[Route('/hello', name: 'app_main_hello')]
    public function hello(): Response
    {
        return $this->render('main/hello.html.twig', [
            'title' => 'HELLO page',
            'data' => [

            ]
        ]);
    }
}
