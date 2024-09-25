<?php

namespace App\Form;

use App\Entity\Color;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class TemplateType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('width')
            ->add('height')
            ->add('color', EntityType::class, [
                'class' => Color::class,
                'choice_label' => 'codeHexa', // Affiche le code hexadécimal de la couleur
                'label' => 'Choose a color',
                'attr' => [
                    'class' => 'form-control' // Ajoutez une classe CSS si nécessaire
                ]
            ])
            ->add('created_at', HiddenType::class)
            ->add('updated_at', HiddenType::class);

            $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {
                $template = $event->getData();
                $form = $event->getForm();
    
                if (!$template || null === $template->getId()) {
                    $form->get('created_at')->setData(new \DateTimeImmutable());
                }
                $form->get('updated_at')->setData(new \DateTimeImmutable());
            });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Vous pouvez définir l'entité associée ici si nécessaire
        ]);
    }
}