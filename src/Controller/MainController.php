<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\EntityA;
use App\Entity\EntityB;
use App\Repository\EntityARepository;
use App\Repository\EntityBRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    #[Route('/', name: 'main_index')]
    public function index(EntityARepository $aRepository, EntityBRepository $bRepository): JsonResponse
    {
        $entityA = EntityA::create("XXX");
        $aRepository->save($entityA);
        $entityB = EntityB::create("X", null);
        $bRepository->save($entityB);

        // ADD
        $entityB->setEntityA($entityA);
        $bRepository->save($entityB);

        // REMOVE
        $bRepository->remove($entityB);
        $aRepository->remove($entityA);


        return $this->json([
            'listA' => $aRepository->findAll(),
            'listB' => $bRepository->findAll()
        ]);
    }
}
