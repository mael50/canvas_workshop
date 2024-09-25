<?php

namespace App\Form;

use App\Entity\Text;
use App\Entity\Template;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TextType extends ElementType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        parent::buildForm($builder, $options);
        $builder
            ->add('textColor', null, [
                'label' => 'Couleur du texte:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('backgroundColor', null, [
                'label' => 'Couleur de fond:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('placeholder', null, [
                'label' => 'Placeholder:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('align', null , [
                'label' => 'Alignement:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                //menu select
                'attr' => ['class' => 'form-select mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('bold', null, [
                'label' => 'Italic:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
            ])
            ->add('italic', null, [
                'label' => 'Italic:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
            ])
            ->add('fontSize', null, [
                'label' => 'Taile d\'écriture:',
                'label_attr' => ['class' => 'text-white mt-2'],
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('fontFamily', null, [
                'label' => 'Italic:',
                'label_attr' => ['class' => 'text-white mt-2'],
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Text::class,
        ]);
    }
}