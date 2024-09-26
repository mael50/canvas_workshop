<?php

namespace App\Form;

use App\Entity\Text;
use App\Entity\Template;
use App\Service\GoogleFontService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Validator\Constraints\Count;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TextType extends ElementType
{
    private $googleFontService;

    public function __construct(GoogleFontService $googleFontService)
    {
        $this->googleFontService = $googleFontService;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $fonts = $this->googleFontService->getFonts();
        $fontChoices = [];

        foreach ($fonts['items'] as $font) {
            $fontChoices[$font['family']] = $font['family'];
        }


        parent::buildForm($builder, $options);
        $builder
            ->add('textColor', ColorType::class, [
                'label' => 'Couleur du texte:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('backgroundColor', ColorType::class, [
                'label' => 'Couleur de fond:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('placeholder', null, [
                'label' => 'Placeholder:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc

                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('align', ChoiceType::class, [
                'label' => 'Alignement:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
                'choices' => [
                    'left' => 'left',
                    'center' => 'center',
                    'right' => 'right',
                    'justify' => 'justify',
                    'justify-all' => 'justify-all',
                    'top' => 'top',
                    'bottom' => 'bottom',
                    'middle' => 'middle',
                    'full' => 'full',
                ],
                //menu select
                'attr' => ['class' => 'form-select mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('bold', null, [
                'label' => 'Gras:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
            ])
            ->add('italic', null, [
                'label' => 'Italique:',
                'label_attr' => ['class' => 'text-white mt-2'],  // Classe pour rendre le label blanc
            ])
            ->add('fontSize', null, [
                'label' => 'Taile d\'écriture:',
                'label_attr' => ['class' => 'text-white mt-2'],
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('fontFamily', ChoiceType::class, [
                'choices' => $fontChoices,
                'autocomplete' => true,
                'placeholder' => '',
                'label' => 'Police:',
                'label_attr' => ['class' => 'text-white mt-2'],
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md'],
                'constraints' => [
                    new Count(min: 1, minMessage: 'Choisissez une police d\'écriture')
                ],
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
