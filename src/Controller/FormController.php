<?php

namespace App\Controller;

use App\Form\TextType;
use App\Form\ImageType;
use App\Form\QRCodeType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormController extends AbstractController
{
    #[Route('/form/{type}', name: 'dynamic_form')]
    public function loadForm(string $type): Response
    {
        switch ($type) {
            case 'image':
                $form = $this->createForm(ImageType::class);
                $formView = $this->renderView('forms/form.html.twig', [
                    'form' => $form->createView(),
                ]);
                break;
            case 'qrcode':
                $form = $this->createForm(QRCodeType::class);
                $formView = $this->renderView('forms/form.html.twig', [
                    'form' => $form->createView(),
                ]);
                break;
            case 'text':
                $form = $this->createForm(TextType::class);
                $formView = $this->renderView('forms/form.html.twig', [
                    'form' => $form->createView(),
                ]);
                break;
            default:
                $formView = '';
        }

        return new Response($formView);
    }
}