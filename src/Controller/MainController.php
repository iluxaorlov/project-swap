<?php

namespace App\Controller;

use App\Repository\FileRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main", methods={"GET"})
     *
     * @param FileRepository $fileRepository
     *
     * @return Response
     */
    public function main(FileRepository $fileRepository): Response
    {
        $files = $fileRepository->findAll();

        return $this->render('main/main.html.twig', [
            'files' => $files,
        ]);
    }
}