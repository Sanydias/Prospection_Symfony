<?php

namespace App\Form;

use App\Entity\Site;
use App\Form\DataTransformer\SiteToNumberTransformer;
use App\Form\DataTransformer\SiteToStringTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutSiteFormType extends AbstractType
{
    // public function __construct(
    //     private SiteToStringTransformer $transformerString,
    //     private SiteToNumberTransformer $transformerNumber,
    // ) {
    // }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departement', NumberType::class, [
                'label' => 'Département',
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => 'validationdElement(this, 0)'
                ]
            ])
            ->add('commune', TextType::class, [
                'label' => 'Commune',
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => 'validationdElement(this, 1)'
                ]
            ])
            ->add('lieuxdit', TextType::class, [
                'label' => 'Lieux-dit',
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => 'validationdElement(this, 2)'
                ]
            ])
            ->add('interethistorique', TextType::class, [
                'label' => 'Intérêt Historique',
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => 'validationdElement(this, 3)'
                ]
            ])
            ->add('lien', TextType::class, [
                'label' => 'Lien',
                'label_attr' => [
                    'required' => false
                ],
                'attr' => [
                    'class' => 'StyleInput'
                ],
                'required' => false
            ])
            ->add('timer', ChoiceType::class, [
                'label' => 'Timer',
                'choices'  => [
                    'Non' => 0,
                    'Oui' => 1,
                ],
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => 'displayTimer(this)'
                ]
            ])
            ->add('typetimer', ChoiceType::class, [
                'label' => 'Type de timer',
                'label_attr' => [
                    'id' => 'typetimer',
                    'required' => false
                ],
                'choices'  => [
                    'Jour' => 'Jour',
                    'Semaine' => 'Semaine',
                    'Mois' => 'Mois',
                ],
                'attr' => [
                    'class' => 'StyleInput'
                ],
                'required' => false
            ])
            ->add('count', HiddenType::class, [
                'mapped' => false,
                'attr' => [
                    'value' => 0,
                ]
            ])
            ->add('valider', ButtonType::class, [
                'label' => 'valider',
                'attr' => [
                    'class' => 'BoutonsEtapes form_non_valide',
                    'onclick' => 'buttonValidation()'
                ]
            ])
        ;
        // $builder
        //     ->get('departement')
        //     ->addModelTransformer($this->transformerNumber);
        // ;
        // $builder
        //     ->get('commune')
        //     ->addModelTransformer($this->transformerString);
        // ;
        // $builder
        //     ->get('lieuxdit')
        //     ->addModelTransformer($this->transformerString);
        // ;
        // $builder
        //     ->get('interethistorique')
        //     ->addModelTransformer($this->transformerString);
        // ;
        // $builder
        //     ->get('lien')
        //     ->addModelTransformer($this->transformerString);
        // ;
        // $builder
        //     ->get('timer')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($timerAsArray): string {
        //             // transform the array to a string
        //             return implode(', ', $timerAsArray);
        //         },
        //         function ($timerAsString): array {
        //             // transform the string back to an array
        //             return explode(', ', $timerAsString);
        //         }
        //     ))
        // ;
        // $builder
        //     ->get('typetimer')
        //     ->addModelTransformer(new CallbackTransformer(
        //         function ($typetimerAsArray): string {
        //             // transform the array to a string
        //             return implode(', ', $typetimerAsArray);
        //         },
        //         function ($typetimerAsString): array {
        //             // transform the string back to an array
        //             return explode(', ', $typetimerAsString);
        //         }
        //     ))
        // ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
