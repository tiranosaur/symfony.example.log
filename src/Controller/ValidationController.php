<?php declare(strict_types=1);

namespace App\Controller;

use App\Entity\Article;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ValidationController extends AbstractController
{
    #[Route('/validation/fail', name: 'app_validation_fail')]
    public function fail(ValidatorInterface $validator): JsonResponse
    {
        $article = new Article();
        $article->setTitle('aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa');
        $article->setPrice(111);
        $article->setContent('lskdj1234567890');

        // --------- validation ----------- //
        $errors = $validator->validate($article);
        if (count($errors) > 0) {
            $errorMessages = [];
            foreach ($errors as $error) {
                $errorMessages[$error->getPropertyPath()][] =  $error->getMessage();
            }
        }
        // ------------------------------ //

        return $this->json([
            'status' => count($errorMessages) == 0 ? 'success' : 'fail',
            'errors' => $errorMessages,
        ]);
    }
}
