<?php

namespace App\Form;

use App\Entity\Color;
use App\Entity\Template;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Twig\Markup;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'class' => 'form-control  rounded-md shadow-sm secondary'
                ]
            ])
            ->add('width', null, [
                'label' => 'Largeur:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control  rounded-md shadow-sm  focus:secondary'
                ]
            ])
            ->add('height', null, [
                'label' => 'Hauteur:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'readonly' => true,
                    'class' => 'form-control rounded-md shadow-sm  focus:secondary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Template::class,
        ]);
    }
}