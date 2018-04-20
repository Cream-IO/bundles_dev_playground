<?php

namespace App\Controller;

use App\Entity\Avatar;
use CreamIO\UploadBundle\Service\UploaderService;
use CreamIO\UserBundle\Entity\BUser;
use CreamIO\BaseBundle\Service\APIService;
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
    public function upload(Request $request, UploaderService $uploader, APIService $apiService): Response
    {
        /** @var Avatar $uploadedFile */
        $uploadedFile = $uploader->handleUpload($request, false);
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(BUser::class)->find('d21406db-1213-494a-a69b-bc9b3a4674d6');
        $uploadedFile->setUser($user);
        $uploader->validateEntity($uploadedFile);
        $em->persist($uploadedFile);
        $em->flush();

        return $apiService->successWithoutResults($uploadedFile->getId(), Response::HTTP_OK, $request);
    }

    /**
     * @Route("", methods="GET")
     */
    public function formUpload(Request $request): Response
    {
        return $this->render('uploaded_file/index.html.twig');
    }
}
