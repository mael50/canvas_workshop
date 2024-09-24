<?php

namespace App\Controller;

use App\Form\ElementType;
use App\Form\TemplateType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateTemplateController extends AbstractController
{
    #[Route('/create-template', name: 'create_template')]
    public function createTemplate(Request $request, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(TemplateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            dd($form->getData());
            die();
            $entityManager->persist($form->getData());
            $entityManager->flush();

            return $this->redirectToRoute('create_template_success');
        }

        return $this->render('create_template/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/create-template/success', name: 'create_template_success')]
    public function createTemplateSuccess(): Response
    {
        return $this->render('create_template/success.html.twig');
    }
}