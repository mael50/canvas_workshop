<?php

namespace App\Form;

use App\Entity\Element;
use App\Entity\Template;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ElementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('posX', RangeType::class, [

                'label' => 'Pos X:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'class' => 'slider mt-2',
                    'min' => 0,  // Valeur minimale
                    'max' => 83,  // Valeur maximale
                ],
            ])
            ->add('posY', RangeType::class, [
                'label' => 'Pos Y:',
                'label_attr' => ['class' => 'text-white mt-2'],

                'attr' => [
                    'class' => 'slider mt-2',
                    'min' => 0,  // Valeur minimale
                    'max' => 83,  // Valeur maximale
                ],
            ])
            ->add('width', RangeType::class, [
                'label' => 'Largeur:',
                'label_attr' => ['class' => 'text-white mt-2'],

                'attr' => [
                    'class' => 'slider mt-2',
                    'min' => 0,  // Valeur minimale
                    'max' => 98,  // Valeur maximale
                ],
            ])
            ->add('height', RangeType::class, [
                'label' => 'Hauteur:',
                'label_attr' => ['class' => 'text-white mt-2'],

                'attr' => [
                    'class' => 'slider mt-2',
                    'min' => 0,  // Valeur minimale
                    'max' => 100,  // Valeur maximale
                ],
            ])
            ->add('inputAssocie', null, [
                'label' => 'Input:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Element::class,
        ]);
    }
}