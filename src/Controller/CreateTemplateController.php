<?php

namespace App\Controller;

use App\Entity\Text;
use App\Entity\Color;
use App\Entity\Image;
use App\Entity\QrCode;
use App\Form\TextType;
use App\Entity\Element;
use App\Form\ImageType;
use App\Entity\Template;
use App\Form\QRCodeType;
use App\Form\ElementType;
use App\Form\TemplateType;
use App\Repository\ElementRepository;
use App\Service\ImageStorage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Collections\ArrayCollection;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CreateTemplateController extends AbstractController
{
    private $imageStorage;
    private $logger;

    public function __construct(ImageStorage $imageStorage, LoggerInterface $logger)
    {
        $this->imageStorage = $imageStorage;
        $this->logger = $logger;
    }

    // Dans votre méthode createTemplate
    #[Route('/create-template/{id}', name: 'create_template', methods: ['GET', 'POST'])]
    public function createTemplate(Request $request, EntityManagerInterface $entityManager, string $id = null, ElementRepository $elementRepository): Response
    {
        $template = null;
        if ($id) {
            $template = $entityManager->getRepository(Template::class)->find($id);
        }

        // Assurez-vous que le template est bien initialisé
        if (!$template) {
            $template = new Template();
        }

        $elements = $elementRepository->findBy(['template' => $template]);

        $form = $this->createForm(TemplateType::class, $template);

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

            return $this->redirectToRoute('create_template', ['id' => $template->getId()]);
        }

        // Gestion des autres formulaires (Image, Text, QRCode)
        if ($imageForm->isSubmitted() && $imageForm->isValid()) {
            $image = $imageForm->getData();

            // Récupérer le fichier uploadé
            $uploadedFile = $imageForm->get('src')->getData();
            $templateColors = $template->getColor();
            if ($uploadedFile) {
                // Utiliser le service imageStorage pour stocker le fichier
                $newFileName = $this->imageStorage->storeFile($uploadedFile, $templateColors);

                // Mettre à jour le chemin du fichier dans l'entité Image
                $image->setSrc($newFileName);
            }

            $entityManager->persist($image);
            $entityManager->flush();

            return $this->redirectToRoute('create_template', ['id' => $template->getId()]);
        }

        if ($textForm->isSubmitted() && $textForm->isValid()) {
            $entityManager->persist($textForm->getData());
            $entityManager->flush();

            return $this->redirectToRoute('create_template', ['id' => $template->getId()]);
        }

        if ($qrCodeForm->isSubmitted() && $qrCodeForm->isValid()) {
            $entityManager->persist($qrCodeForm->getData());
            $entityManager->flush();

            return $this->redirectToRoute('create_template', ['id' => $template->getId()]);
        }

        return $this->render('create_template/index.html.twig', [
            'form' => $form->createView(),
            'imageForm' => $imageForm->createView(),
            'textForm' => $textForm->createView(),
            'qrCodeForm' => $qrCodeForm->createView(),
            'template' => $template,
            'elements' => $elements,
        ]);
    }

    #[Route('/create-element/add-element', name: 'create_template_add_element', methods: ['POST'])]
    public function addElement(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $this->logger->info('addElement called');
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            $this->logger->error('Invalid JSON');
            return new JsonResponse(['error' => 'Invalid JSON'], Response::HTTP_BAD_REQUEST);
        }

        $id = $data['id'] ?? null;

        if ($id) {
            $element = $entityManager->getRepository(Element::class)->find($id);

            if ($element) {
                if (isset($data['posX'], $data['posY'], $data['width'], $data['height'])) {
                    $element->setPosX($data['posX'])
                        ->setPosY($data['posY'])
                        ->setWidth($data['width'])
                        ->setHeight($data['height'])
                        ->setInputAssocie($data['inputAssocie']);
                }

                // si c'est une image
                if ($data['type'] === 'image') {
                    $image = $entityManager->getRepository(Image::class)->find($id);
                    $element->setSrc($image);
                    $element->setName(null);
                }

                // si c'est un texte
                if ($data['type'] === 'text') {
                    $element->setTextColor($data['textColor']);
                    $element->setBackgroundColor($data['backgroundColor']);
                    $element->setPlaceHolder($data['placeHolder']);
                    $element->setAlign($data['align']);
                    $element->isBold($data['isBold']);
                    $element->isItalic($data['isItalic']);
                    $element->setFontSize($data['fontSize']);
                    $element->setFontFamily($data['fontFamily']);
                }

                // si c'est un qrcode
                if ($data['type'] === 'qrcode') {
                    $element->setText($data['text']);
                }

                $entityManager->flush();
                return new JsonResponse(null, Response::HTTP_OK);
            }
        } else {
            // Créer un nouvel élément en fonction du type
            $type = $data['type'];
            if ($type === 'image') {
                $element = new Image();
                $element->setSrc($data['src']);
            } elseif ($type === 'text') {
                $element = new Text();
                $element->setTextColor($data['textColor']);
                $element->setBackgroundColor($data['backgroundColor']);
                $element->setPlaceHolder($data['placeHolder']);
                $element->setAlign($data['align']);
                $element->setBold($data['isBold']); // Use setBold instead of isBold
                $element->setItalic($data['isItalic']); // Use setItalic instead of isItalic
                $element->setFontSize($data['fontSize']);
                $element->setFontFamily($data['fontFamily']);
            } elseif ($type === 'qrcode') {
                $element = new QrCode();
                $element->setText($data['text']);
            } else {
                return new JsonResponse(['error' => 'Type non supporté'], Response::HTTP_BAD_REQUEST);
            }

            $element->setPosX($data['posX'])
                ->setPosY($data['posY'])
                ->setWidth($data['width'])
                ->setHeight($data['height'])
                ->setInputAssocie($data['inputAssocie'])
                ->setTemplate($entityManager->getRepository(Template::class)->find($data['templateId']));

            $entityManager->persist($element);
            $entityManager->flush();
            return new JsonResponse(['id' => $element->getId()], Response::HTTP_CREATED);
        }

        return new JsonResponse(['error' => 'Element not found'], Response::HTTP_BAD_REQUEST);
    }

    #[Route('/save-template/{id}', name: 'save_template', methods: ['POST'])]
    public function saveTemplate(Request $request, EntityManagerInterface $entityManager, int $id): Response
    {
        $template = $entityManager->getRepository(Template::class)->find($id);

        if (!$template) {
            throw $this->createNotFoundException('Template not found');
        }

        $form = $this->createForm(TemplateType::class, $template);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $template->setUpdatedAt(new \DateTimeImmutable());
            $entityManager->flush();

            $this->addFlash('success', 'Template mis à jour avec succès.');
        } else {
            $this->addFlash('error', 'Une erreur est survenue lors de la mise à jour du template.');
        }

        return $this->redirectToRoute('app_home');
    }
}