<?php

namespace App\Form;

use App\Entity\Color;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', null, [
                'label' => 'Nom:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'readonly' => true  ,
                    'value'=> 'Template name',
                    'class' => 'form-control  rounded-md shadow-sm secondary'
                ]
            ])
            ->add('width', null, [
                'label' => 'Largeur:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'readonly' => true  ,
                    'value'=> '123',
                    'class' => 'form-control  rounded-md shadow-sm  focus:secondary'
                ]
            ])
            ->add('height', null, [
                'label' => 'Hauteur:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'readonly' => true  ,
                    'value'=> '123',
                    'class' => 'form-control rounded-md shadow-sm  focus:secondary'
                ]
            ])
            ->add('color', null, [
                'label' => 'Couleur:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'attr' => [
                    'readonly' => true ,
                    'value'=> '#1234 + #1124',
                    'class' => 'form-control rounded-md shadow-sm focus:secondary'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Vous pouvez définir l'entité associée ici si nécessaire
        ]);
    }
}