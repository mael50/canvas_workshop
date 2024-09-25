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
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('backgroundColor', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('placeholder', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('align', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('bold', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('italic', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('fontSize', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('fontFamily', null, [
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