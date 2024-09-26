<?php

namespace App\Controller;

use App\Entity\Element;
use App\Form\ElementType;
use App\Repository\ElementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
//use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/element')]
final class ElementController extends AbstractController
{
    #[Route(name: 'app_element_index', methods: ['GET'])]
    public function index(ElementRepository $elementRepository): Response
    {
        return $this->render('element/index.html.twig', [
            'elements' => $elementRepository->findAll(),
        ]);
    }
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

    #[Route('/new', name: 'app_element_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $element = new Element();
        $form = $this->createForm(ElementType::class, $element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($element);
            $entityManager->flush();

            return $this->redirectToRoute('app_element_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('element/new.html.twig', [
            'element' => $element,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_element_show', methods: ['GET'])]
    public function show(Element $element): Response
    {
        return $this->render('element/show.html.twig', [
            'element' => $element,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_element_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Element $element, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ElementType::class, $element);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_element_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('element/edit.html.twig', [
            'element' => $element,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_element_delete', methods: ['POST'])]
    public function delete(Request $request, Element $element, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$element->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($element);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_element_index', [], Response::HTTP_SEE_OTHER);
    }
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
