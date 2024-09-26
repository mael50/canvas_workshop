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
                    'top-left' => 'top-left',
                    'top-center' => 'top-center',
                    'top-right' => 'top-right',
                    'center-left' => 'center-left',
                    'center-center' => 'center-center',
                    'center-right' => 'center-right',
                    'bottom-left' => 'bottom-left',
                    'bottom-center' => 'bottom-center',
                    'bottom-right' => 'bottom-right',
                    'justify' => 'justify',

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
                'choices' => [
                    'Arial' => 'Arial',
                    'Times New Roman' => 'Times New Roman',
                    'Verdana' => 'Verdana',
                    'Courier New' => 'Courier New',
                    'Georgia' => 'Georgia',
                    'Palatino Linotype' => 'Palatino Linotype',
                    'Comic Sans MS' => 'Comic Sans MS',
                    'Lucida Sans Unicode' => 'Lucida Sans Unicode',
                    'Trebuchet MS' => 'Trebuchet MS',
                    'Tahoma' => 'Tahoma',
                    'Arial Black' => 'Arial Black',
                    'Impact' => 'Impact',
                    'Lucida Console' => 'Lucida Console'
                ],
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
