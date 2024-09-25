<?php

namespace App\Controller;

use App\Entity\Template;
use App\Repository\TemplateRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\TypeInfo\Type\TemplateType;
use Symfony\Component\HttpFoundation\Request;

class TemplateController extends AbstractController
{
    private TemplateRepository $templateRepository;
    private EntityManagerInterface $entityManager;

    public function __construct(TemplateRepository $templateRepository, EntityManagerInterface $entityManager)
    {
        $this->templateRepository = $templateRepository;
        $this->entityManager = $entityManager;
    }

    #[Route('/template', name: 'app_template_create', methods: ['POST'])]
    public function create(Request $request): Response
    {
        $template = new Template();

        // Récupérer les données de la requête
        $data = json_decode($request->getContent(), true);

        // Vérifier si les données nécessaires sont présentes
        if (!isset($data['name'], $data['width'], $data['height'], $data['colors'])) {
            return $this->json(['error' => 'Missing required fields'], Response::HTTP_BAD_REQUEST);
        }

        // Définir les propriétés de l'objet Template
        $template->setName($data['name']);
        $template->setWidth($data['width']);
        $template->setHeight($data['height']);

        // Ajouter les couleurs à l'objet Template
        foreach ($data['colors'] as $colorId) {
            $color = $this->entityManager->getReference('App\Entity\Color', $colorId);
            $template->addColor($color);
        }

        // Persister l'objet Template dans la base de données
        $this->entityManager->persist($template);
        $this->entityManager->flush(); // Enregistre les changements dans la base de données
        return $this->json(['success' => true]);
    }

    #[Route('/template/{id} ', name: 'app_template_read', methods: ['POST'])]
    public function delete(Request $request)
    {
        $id= $request->get('id');
        $template= $this->templateRepository->find($id);
        $this->entityManager->remove($template);
        $this->entityManager->flush();
        return $this->json(['success' => true]);
    }
}
