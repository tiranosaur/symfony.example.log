<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormController extends AbstractController
{
    #[Route('/form/controller', name: 'app_form_controller', methods: ['GET', 'POST'])]
    public function controller(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();

        $form = $this->createFormBuilder($article)
            ->add('author', TextType::class)
            ->add('title', TextType::class)
            ->add('content', TextType::class)
            ->add('price', NumberType::class)
            ->add('save', SubmitType::class, ['label' => 'Create Article'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        //TODO            Save the article to the database
        //            $entityManager->persist($article);
        //            $entityManager->flush();

            // Redirect to a new page or display a success message
            return $this->redirectToRoute('app_form_success');
        }

        return $this->render('form/index.html.twig', [
            'title' => 'Form in Controller',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/class', name: 'app_form_class', methods: ['GET', 'POST'])]
    public function class(Request $request, EntityManagerInterface $entityManager): Response
    {
        $article = new Article();

        $form = $this->createForm(ArticleFormType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
        //TODO            Save the article to the database
        //            $entityManager->persist($article);
        //            $entityManager->flush();

            // Redirect to a new page or display a success message
            return $this->redirectToRoute('app_form_success');
        }

        return $this->render('form/index.html.twig', [
            'title' => 'Form in Controller',
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/success', name: 'app_form_success', methods: ['GET'])]
    public function success(Request $request): JsonResponse
    {
        return $this->json(['success' => true]);
    }
}

