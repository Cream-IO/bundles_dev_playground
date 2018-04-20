<?php

namespace App\Service;

use App\Entity\UserStoredFile;
use CreamIO\UserBundle\Service\APIService;
use GBProd\UuidNormalizer\UuidNormalizer;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;

class UploaderService
{
    private $apiService;

    private $targetDirectory;

    public function __construct(string $targetDirectory, APIService $apiService)
    {
        $this->apiService = $apiService;
        $this->targetDirectory = $targetDirectory;
    }

    public function generateSerializer(): Serializer
    {
        $encoders = [new JsonEncoder()];
        $objectNormalizer = new ObjectNormalizer();
        $normalizers = [new DateTimeNormalizer('d-m-Y H:i:s', new \DateTimeZone('Europe/Paris')), $objectNormalizer, new UuidNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);

        return $serializer;
    }

    public function handleFileUpload(Request $request): UserStoredFile
    {
        $file = $request->files->get('uploaded_file');
        /** @var UploadedFile $file */
        $filename = $this->moveUploadedFile($file);
        $postDatas = $request->request->all();
        $postDatas['file'] = $filename;
        $uploadedFile = $this->generateSerializer()->denormalize($postDatas, UserStoredFile::class);

        return $uploadedFile;
    }

    public function moveUploadedFile(UploadedFile $file): string
    {
        $fileName = md5(uniqid()).'.'.$file->guessExtension();
        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }

    public function generateUniqueFilename(): string
    {
        return md5(uniqid('creamio_', true));
    }

    public function getTargetDirectory()
    {
        return $this->targetDirectory;
    }
}
