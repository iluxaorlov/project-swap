<?php

namespace App\Controller;

use App\Entity\File;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class FileController extends AbstractController
{
    /**
     * @Route("/", name="load", methods={"POST"})
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function load(Request $request)
    {
        $files = $request->files->get('files');

        $entityManager = $this->getDoctrine()->getManager();

        /** @var UploadedFile $file */
        foreach ($files as $file) {
            $fileEntity = new File();
            $fileEntity->setName($file->getClientOriginalName());
            $fileEntity->setExtension($file->getClientOriginalExtension());
            $fileEntity->setSize($file->getSize());
            $fileEntity->setTimestamp(time());

            $entityManager->persist($fileEntity);

            $file->move(
                $this->getParameter('fileStore'),
                $fileEntity->getId() . '.' . $fileEntity->getExtension()
            );
        }

        $entityManager->flush();

        return $this->redirectToRoute('main');
    }
}
