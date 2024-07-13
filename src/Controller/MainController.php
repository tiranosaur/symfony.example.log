<?php

namespace App\Controller;

use App\Repository\EntityARepository;
use App\Repository\EntityBRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'title' => 'Main Page',
            'data' => [
                $this->generateUrl('main_manyToManyInAction') => 'Many to Many IN ACTION'
            ]
        ]);
    }

    #[Route('/manyToManyInAction', name: 'main_manyToManyInAction')]
    public function manyToManyInAction(EntityARepository $aRepository, EntityBRepository $bRepository, SerializerInterface $serializer): JsonResponse
    {
        $list = $aRepository->list();

        $entityA = $aRepository->find(2);
        $entityB = $bRepository->find(3);
        $json = json_encode($entityA);

        // REMOVE a
        $entityA->removeEntityB($entityB);
        $aRepository->save($entityA);
        // SAVE a
        $entityA->addEntityB($entityB);
        $aRepository->save($entityA);

        // REMOVE b
        $entityB->removeEntityA($entityA);
        $bRepository->save($entityB);
        // SAVE b
        $entityB->addEntityA($entityA);
        $bRepository->save($entityB);

        return new JsonResponse([
            'entityA' => $entityA,
            'entityB' => $entityB,
            'list' => $list,
            'json' => $json
        ]);
    }
}