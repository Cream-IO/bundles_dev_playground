<?php

namespace App\Controller;

use App\Service\UploaderService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class UploadedFileController.
 *
 * @Route("/file-upload")
 */
class UploadedFileController extends Controller
{
    /**
     * @Route("", methods="POST")
     */
    public function upload(Request $request, UploaderService $uploader): Response
    {
        $uploadedFile = $uploader->handleFileUpload($request);
        $em = $this->getDoctrine()->getManager();
        $em->persist($uploadedFile);
        $em->flush();

        return new Response($uploadedFile->getFile());
    }

    /**
     * @Route("", methods="GET")
     */
    public function formUpload(Request $request): Response
    {
        return $this->render('uploaded_file/index.html.twig');
    }
}
