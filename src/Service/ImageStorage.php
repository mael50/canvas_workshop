<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ImageStorage
{
    private $targetDirectory;

    public function __construct(string $targetDirectory)
    {
        $this->targetDirectory = $targetDirectory;
    }

    public function storeFile(UploadedFile $file): string
    {
        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        $file->move($this->getTargetDirectory(), $fileName);

        return $fileName;
    }


    public function deleteFile(string $fileName): void
    {
        $file = $this->getTargetDirectory() . '/' . $fileName;

        if (file_exists($file)) {
            unlink($file);
        }

        return;
    }

    public function getTargetDirectory(): string
    {
        return $this->targetDirectory;
    }
}