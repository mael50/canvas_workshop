<?php

namespace App\DataFixtures;

use App\Entity\Color;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $colors = [
            '#FF0000',
            '#000000',
            '#FFFFFF',
            '#FFFF00',
        ];

        foreach ($colors as $color) {
            $colour = new Color();
            $colour->setCodeHexa($color);
            $manager->persist($colour);
        }

        $manager->flush();
    }
}