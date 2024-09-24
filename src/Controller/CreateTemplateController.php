<?php

namespace App\Controller;

use App\Form\TemplateType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateTemplateController extends AbstractController
{
    #[Route('/create-template', name: 'create_template')]
    public function createTemplate(Request $request): Response
    {
        $form = $this->createForm(TemplateType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            
            // Effectuez ici les opérations souhaitées (par exemple, sauvegarder les données)
        }

        return $this->render('create_template/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
