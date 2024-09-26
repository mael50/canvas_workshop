<?php

namespace App\Service;

use Endroid\QrCode\QrCode;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;


class QRCodeService
{
    public function generateQRCode(string $data): string
    {
        $writer = new PngWriter();
        // $qrCode = QrCodeFactory::create($data);
        $qrcode = QrCode::create($data)
            ->setSize(300)
            ->setBackgroundColor(new Color(255, 255, 255))
            ->setForegroundColor(new Color(0, 0, 0))
            ->setEncoding(new Encoding('UTF-8'));

        $result = $writer->write($qrcode);

        // $writer->validateResult($result, $data);

        return $result->getString();

        // file_put_contents('uploads/qrcode.png', $result);
    }
}