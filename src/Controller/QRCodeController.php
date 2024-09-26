<?php

namespace App\Controller;

use App\Service\QRCodeService;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class QRCodeController extends AbstractController
{
    #[Route('/generate-qrcode/{data}', name: 'generate_qrcode', requirements: ['data' => '.+'])]
    public function generate(QRCodeService $QRCodeService, string $data): Response
    {
        $qrCodeImage = $QRCodeService->generateQRCode($data);

        return new Response(
            $qrCodeImage,
            Response::HTTP_OK,
            ['Content-Type' => 'image/png']
        );
    }
}