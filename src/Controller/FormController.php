<?php

namespace App\Controller;

use App\Entity\Text;
use App\Entity\Image;
use App\Entity\QrCode;
use App\Form\TextType;
use App\Form\ImageType;
use App\Form\QRCodeType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class FormController extends AbstractController
{
    #[Route('/form/image', name: 'form_image')]
    public function formImage(FormFactoryInterface $formFactory): Response
    {
        $image = new Image();
        $form = $formFactory->create(ImageType::class, $image);

        return $this->render('form/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/qrcode', name: 'form_qrcode')]
    public function formQRCode(FormFactoryInterface $formFactory): Response
    {
        $qrcode = new QrCode();
        $form = $formFactory->create(QRCodeType::class, $qrcode);

        return $this->render('form/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/form/text', name: 'form_text')]
    public function formText(FormFactoryInterface $formFactory): Response
    {
        $text = new Text();
        $form = $formFactory->create(TextType::class, $text);

        return $this->render('form/_form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}