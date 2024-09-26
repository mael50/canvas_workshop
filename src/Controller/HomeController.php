<?php

namespace App\Controller;

use App\Entity\Template;
use App\Repository\TemplateRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{

    #[Route('/', name: 'app_home')]
    public function index(TemplateRepository $templateRepository): Response
    {
        $templates = $templateRepository->findAll();

        // order by most recent
        usort($templates, function (Template $a, Template $b) {
            return $b->getUpdatedAt() <=> $a->getUpdatedAt();
        });

        return $this->render('home/index.html.twig', [
            'templates' => $templates,
        ]);
    }
}
