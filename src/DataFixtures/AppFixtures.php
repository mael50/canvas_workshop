<?php

namespace App\DataFixtures;

use App\Entity\Color;
use App\Entity\Template;
use App\Entity\Image;
use App\Entity\QrCode;
use App\Entity\Text;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Create Colors
        $colors = [
            '#FF0000', // Red
            '#00FF00', // Green
            '#0000FF', // Blue
            '#FFFF00', // Yellow
            '#FF00FF', // Magenta
            '#00FFFF', // Cyan
        ];

        $colorEntities = [];
        foreach ($colors as $color) {
            $colorEntity = new Color();
            $colorEntity->setCodeHexa($color);
            $manager->persist($colorEntity);
            $colorEntities[] = $colorEntity;
        }

        // Create Template
        $template = new Template();
        $template->setName('Test Template')
                 ->setWidth(800.0)
                 ->setHeight(600.0);

        // Add Colors to Template
        foreach ($colorEntities as $colorEntity) {
            $template->addColor($colorEntity);
        }

        $manager->persist($template);

        // Create Image Element
        $image = new Image();
        $image->setPosX(100.0)
              ->setPosY(150.0)
              ->setWidth(200.0)
              ->setHeight(100.0)
              ->setSrc('image.jpg')
              ->setName('Test Image')
              ->setInputAssocie('default_value')
              ->setTemplate($template);

        $manager->persist($image);

        // Create QrCode Element
        $qrCode = new QrCode();
        $qrCode->setPosX(300.0)
               ->setPosY(350.0)
               ->setWidth(100.0)
               ->setHeight(100.0)
               ->setText('https://example.com')
               ->setInputAssocie('default_value')
               ->setTemplate($template);

        $manager->persist($qrCode);

        // Create Text Element
        $text = new Text();
        $text->setPosX(400.0)
             ->setPosY(450.0)
             ->setWidth(200.0)
             ->setHeight(50.0)
             ->setTextColor('#000000')
             ->setBackgroundColor('#FFFFFF')
             ->setPlaceholder('Enter text here')
             ->setAlign('center')
             ->setBold(true)
             ->setItalic(false)
             ->setFontSize(14.0)
             ->setFontFamily('Arial')
             ->setInputAssocie('default_value')
             ->setTemplate($template);

        $manager->persist($text);

        // Flush to save data to the database
        $manager->flush();
    }
}