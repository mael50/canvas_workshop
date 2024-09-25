<?php

namespace App\Controller;

use App\Form\TextType;
use App\Form\ImageType;
use App\Entity\Template;
use App\Form\QRCodeType;
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
        $imageForm = $this->createForm(ImageType::class);
        $textForm = $this->createForm(TextType::class);
        $qrCodeForm = $this->createForm(QRCodeType::class);

        $form->handleRequest($request);
        $imageForm->handleRequest($request);
        $textForm->handleRequest($request);
        $qrCodeForm->handleRequest($request);

        // Gestion du formulaire Template
        if ($form->isSubmitted() && $form->isValid()) {
            $template = new Template();
            $template->setName($form->get('name')->getData());
            $template->setWidth($form->get('width')->getData());
            $template->setHeight($form->get('height')->getData());
            $template->setCreatedAt(new \DateTimeImmutable()); // Définit created_at
            $template->setUpdatedAt(new \DateTimeImmutable()); // Définit updated_at

            // Gestion des couleurs si besoin
            foreach ($form->get('color')->getData() as $color) {
                $template->addColor($color);
            }

            $entityManager->persist($template);
            $entityManager->flush();

            return $this->redirectToRoute('create_template');
        }

        // Gestion des autres formulaires (Image, Text, QRCode)
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $entityManager->persist($imageForm->getData());
            $entityManager->flush();

            return $this->redirectToRoute('create_template');
        }

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $entityManager->persist($textForm->getData());
            $entityManager->flush();

            return $this->redirectToRoute('create_template');
        }

        if ($qrCodeForm->isSubmitted() && $qrCodeForm->isValid()) {
            $entityManager->persist($qrCodeForm->getData());
            $entityManager->flush();

            return $this->redirectToRoute('create_template');
        }

        return $this->render('create_template/index.html.twig', [
            'form' => $form->createView(),
            'imageForm' => $imageForm->createView(),
            'textForm' => $textForm->createView(),
            'qrCodeForm' => $qrCodeForm->createView(),
        ]);
    }
}
