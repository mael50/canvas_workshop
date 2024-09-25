<?php

namespace App\Controller;

use App\Entity\Template;
use App\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    #[Route('/home', name: 'app_home')]
    public function index(TemplateRepository $templateRepository): Response
    {
        $templates = $templateRepository->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'templates' => $templates,
        ]);
    }
}