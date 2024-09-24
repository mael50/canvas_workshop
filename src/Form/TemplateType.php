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
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'codeHexa', // Affiche le code hexadécimal de la couleur
                'label' => 'Choose a color',
                'attr' => [
                    'class' => 'form-control' // Ajoutez une classe CSS si nécessaire
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
