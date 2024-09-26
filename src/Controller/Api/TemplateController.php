<?php
namespace App\Controller\Api;

use App\Entity\Template;
use App\Entity\Image;
use App\Entity\QrCode;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;

class TemplateController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/template/{id}', name: 'api_template_show', methods: ['GET'])]
    public function show($id): JsonResponse
    {
        $template = $this->entityManager->getRepository(Template::class)->find($id);
    
        if (!$template) {
            return new JsonResponse(['message' => 'Template not found'], 404);
        }
    
        // Récupération des couleurs liées au template
        $colors = [];
        foreach ($template->getColor() as $color) {
            $colors[] = [
                'id' => $color->getId(),
                'codeHexa' => $color->getCodeHexa(),
            ];
        }
    
        // Récupération des éléments liés au template
        $text = [];
        $images = [];
        $qrCodes = [];
        
        foreach ($template->getElements() as $element) {
            $elementData = [
                'id' => $element->getId(),
                'posX' => $element->getPosX(),
                'posY' => $element->getPosY(),
                'width' => $element->getWidth(),
                'height' => $element->getHeight(),
            ];

            if($element instanceof Text) {
                $text[] = array_merge($elementData, [
                    'content' => $element->getContent(),
                    'fontSize' => $element->getFontSize(),
                    'fontColor' => $element->getFontColor(),
                ]);
            } elseif ($element instanceof Image) {
                $images[] = array_merge($elementData, [
                    'src' => $element->getSrc(),
                    'name' => $element->getName(),
                ]);
            } elseif ($element instanceof QrCode) {
                $qrCodes[] = array_merge($elementData, [
                    'text' => $element->getText(),
                ]);
            } else {
                $elements[] = $elementData;
            }
            
            if ($element instanceof Image) {
                $images[] = array_merge($elementData, [
                    'src' => $element->getSrc(),
                    'name' => $element->getName(),
                ]);
            } elseif ($element instanceof QrCode) {
                $qrCodes[] = array_merge($elementData, [
                    'text' => $element->getText(),
                ]);
            } else {
                $elements[] = $elementData;
            }
        }
    
        // Données du template à retourner
        $data = [
            'id' => $template->getId(),
            'name' => $template->getName(),
            'width' => $template->getWidth(),
            'height' => $template->getHeight(),
            'colors' => $colors,
            'text' => $text,
            'images' => $images,
            'qrCodes' => $qrCodes,
        ];
    
        return new JsonResponse(json_encode($data, JSON_PRETTY_PRINT), 200, [], true);
    }
}
