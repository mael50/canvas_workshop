<?php

namespace App\Controller;

use App\Entity\Element;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

class ElementController extends AbstractController
{
    #[Route('/element/{id}', name: 'element_show')]
    public function show(int $id, EntityManagerInterface $entityManager): Response
    {
        // Récupérer l'élément par son ID
        $element = $entityManager->getRepository(Element::class)->find($id);

        // Si l'élément n'existe pas, lancer une erreur
        if (!$element) {
            throw $this->createNotFoundException('Element not found');
        }

        // Renvoyer l'élément à la vue pour l'afficher
        return $this->render('element/index.html.twig', [
            'element' => $element
        ]);
    }
}
