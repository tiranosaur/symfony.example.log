<?php declare(strict_types=1);

namespace App\Controller;

use App\Request\FileUploadRequest;
use App\Service\FileService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    #[Route('/file', name: 'app_file_index', methods: ['GET'])]
    public function index(FileService $fileService): Response
    {
        $fileList = $fileService->getFileList();

        $fileUploadForm = $this->createUploadForm();

        return $this->render('file/index.html.twig', [
            'title' => 'File',
            'fileUploadForm' => $fileUploadForm->createView(),
            'fileList' => $fileList,
        ]);
    }

    #[Route('/file', name: 'app_file_upload', methods: ['POST'])]
    public function upload(Request $request, FileService $fileService): Response
    {
        $fileList = $fileService->getFileList();
        $fileUploadForm = $this->createUploadForm();

        $fileUploadForm->handleRequest($request);
        if ($fileUploadForm->isSubmitted() && $fileUploadForm->isValid()) {
            $fileService->upload($fileUploadForm->getData());
        }

        return $this->render('file/index.html.twig', [
            'title' => 'File',
            'fileUploadForm' => $fileUploadForm->createView(),
            'fileList' => $fileList,
        ]);
    }

    #[Route('/file', name: 'app_file_delete', methods: ['DELETE'])]
    public function delete(Request $request, FileService $fileService): JsonResponse
    {
        $json = json_decode($request->getContent(), true);
        $fileService->delete($json['filename']);
        return new JsonResponse(null, Response::HTTP_OK);
    }

    function createUploadForm(): FormInterface
    {
        $fileUpload = new FileUploadRequest();
        return $this->createFormBuilder($fileUpload)
            ->add('description', TextType::class, ['required' => false,])
            ->add('file', FileType::class)
            ->add('submit', SubmitType::class)
            ->getForm();
    }
}
