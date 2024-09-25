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
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('posY', RangeType::class, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('width', RangeType::class, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('height', RangeType::class, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('inputAssocie', null, [
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