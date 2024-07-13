<?php

namespace App\Controller;

use App\Entity\EntityB;
use App\Repository\EntityARepository;
use App\Repository\EntityBRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
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
                $this->generateUrl('main_oneToMany') => "ONE TO MANY"
            ]
        ]);
    }

    #[Route('/oneToMany', name: 'main_oneToMany')]
    public function oneToMany(EntityARepository $aRepository, EntityBRepository $bRepository): JsonResponse
    {
        $entityA = $aRepository->find(1);
        $entityB = $bRepository->find(3);

        // REMOVE
        $tmpB = $bRepository->findOneBy(['name' => 'new XXX']);
        if ($tmpB != null) {
            $bRepository->remove($tmpB);
        }
        // ADD
        $tmpB = EntityB::create("new XXX", $entityA);
        $bRepository->save($tmpB);

        $list = $aRepository->findAll();
        return $this->json([
            'list' => $list,
            'entityA' => $entityA,
            'entityB' => $entityB
        ]);
    }
}
