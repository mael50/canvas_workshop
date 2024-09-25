<?php

namespace App\Controller;

use App\Service\GoogleFontService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    #[Route('/home', name: 'app_home')]
    public function index(GoogleFontService $googleFontsService): Response
    {
        // Appel au service pour obtenir les polices
        $fonts = $googleFontsService->getFonts();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'fonts' => $fonts['items'],
        ]);
    }
}
