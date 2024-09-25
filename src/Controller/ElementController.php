<?php

namespace App\Controller;

use App\Entity\Element;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ElementController extends AbstractController
{
    // Route pour afficher tous les éléments
    #[Route('/elements', name: 'elements_show', methods: ['GET'])]
    public function showElements(EntityManagerInterface $entityManager): Response
    {
        // Récupérer tous les éléments
        $elements = $entityManager->getRepository(Element::class)->findAll();

        // Renvoyer tous les éléments à la vue
        return $this->render('element/index.html.twig', [
            'elements' => $elements
        ]);
    }

    // Route pour mettre à jour la position d'un élément via AJAX
    #[Route('/element/update-position', name: 'element_update_position', methods: ['POST'])]
    public function updatePosition(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        // Récupérer les données envoyées par AJAX
        $data = json_decode($request->getContent(), true);

        // Trouver l'élément par son ID
        $element = $entityManager->getRepository(Element::class)->find($data['id']);

        // Si l'élément n'existe pas, retourner une erreur
        if (!$element) {
            return new JsonResponse(['success' => false, 'error' => 'Element non trouvé'], 404);
        }

        // Mettre à jour les positions posX et posY
        $element->setPosX($data['posX']);
        $element->setPosY($data['posY']);

        // Sauvegarder les nouvelles positions en base de données
        $entityManager->flush();

        // Répondre avec succès
        return new JsonResponse(['success' => true]);
    }
}
