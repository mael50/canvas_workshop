<?php

namespace App\Controller;

use App\Repository\ColorRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class ColorsController extends AbstractController
{
    protected ColorRepository $colorRepository;

    public function __construct(ColorRepository $colorRepository)
    {
        $this->colorRepository = $colorRepository;
    }

    #[Route('/colors', name: 'app_colors')]
    public function index(): JsonResponse
    {
        // Fetch all colors from the repository
        $colors = $this->colorRepository->findAll();

        // Transform the Color entities to a format suitable for JSON response
        $colorData = array_map(function($color) {
            return [
                'id' => $color->getId(), // Assuming getId() exists in your Color entity
                'codeHexa' => $color->getCodeHexa(), // Assuming getCodeHexa() exists in your Color entity
            ];
        }, $colors);

        // Return the color data as a JsonResponse
        return $this->json($colorData);
    }

}
