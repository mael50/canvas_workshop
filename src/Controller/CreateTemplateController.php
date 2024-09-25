<?php

namespace App\Controller;

use App\Entity\Image;
use App\Form\TextType;
use App\Form\ImageType;
use App\Entity\Template;
use App\Form\QRCodeType;
use App\Form\ElementType;
use App\Form\TemplateType;
use App\Service\ImageStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateTemplateController extends AbstractController
{
    private $imageStorage;

    public function __construct(ImageStorage $imageStorage)
    {
        $this->imageStorage = $imageStorage;
    }


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

        if ($form->isSubmitted() && $form->isValid()) {
            $template = new Template();
            $template->setName($form->get('name')->getData());
            $template->setWidth($form->get('width')->getData());
            $template->setHeight($form->get('height')->getData());

            $entityManager->persist($template);
            $entityManager->flush();

            return $this->redirectToRoute('create_template');
        }

        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $image = $imageForm->getData();

            // Récupérer le fichier uploadé
            $uploadedFile = $imageForm->get('src')->getData();

            if ($uploadedFile) {
                // Utiliser le service imageStorage pour stocker le fichier
                $newFileName = $this->imageStorage->storeFile($uploadedFile);

                // Mettre à jour le chemin du fichier dans l'entité Image
                $image->setSrc($newFileName);
            }

            $entityManager->persist($image);
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