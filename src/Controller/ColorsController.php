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

        $colors = $this->colorRepository->findAll();

        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ColorsController.php',
        ]);
    }
}
