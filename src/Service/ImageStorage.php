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

    public function storeFile(UploadedFile $file, array $templateColors): string
    {
        // Convertir les codes hexadécimaux en valeurs RGB
        $rgbTemplateColors = array_map(function ($hexColor) {
            return [
                'red' => hexdec(substr($hexColor, 1, 2)),
                'green' => hexdec(substr($hexColor, 3, 2)),
                'blue' => hexdec(substr($hexColor, 5, 2))
            ];
        }, $templateColors);

        // parse image to only accept template colors
        $image = imagecreatefromstring(file_get_contents($file->getPathname()));
        $width = imagesx($image);
        $height = imagesy($image);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $rgb = imagecolorat($image, $x, $y);
                $colors = imagecolorsforindex($image, $rgb);

                $pixelColor = ['red' => $colors['red'], 'green' => $colors['green'], 'blue' => $colors['blue']];

                // Trouver la couleur la plus proche
                $closestColor = null;
                $minDistance = PHP_INT_MAX;
                foreach ($rgbTemplateColors as $templateColor) {
                    $distance = sqrt(
                        pow($pixelColor['red'] - $templateColor['red'], 2) +
                            pow($pixelColor['green'] - $templateColor['green'], 2) +
                            pow($pixelColor['blue'] - $templateColor['blue'], 2)
                    );

                    if ($distance < $minDistance) {
                        $minDistance = $distance;
                        $closestColor = $templateColor;
                    }
                }

                // Remplacer la couleur du pixel par la couleur la plus proche
                $color = imagecolorallocate($image, $closestColor['red'], $closestColor['green'], $closestColor['blue']);
                imagesetpixel($image, $x, $y, $color);
            }
        }

        $fileName = md5(uniqid()) . '.' . $file->guessExtension();
        imagepng($image, $this->getTargetDirectory() . '/' . $fileName);
        imagedestroy($image);

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
