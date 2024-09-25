<?php

namespace App\Form;

use App\Entity\Text;
use App\Entity\Template;
use App\Service\GoogleFontService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\ColorType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Contracts\HttpClient\HttpClientInterface;

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
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('backgroundColor', ColorType::class, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('placeholder', null, [
                'attr' => ['class' => 'form-input mt-1 block w-full border-gray-300 rounded-md']
            ])
            ->add('align', ChoiceType::class, [
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
            ->add('fontFamily', ChoiceType::class, [
                'choices' => $fontChoices,
                'attr' => [
                    'class' => 'form-input mt-1 block w-full border-gray-300 rounded-md'
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