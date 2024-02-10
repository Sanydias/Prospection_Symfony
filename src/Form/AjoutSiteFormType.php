<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutSiteFormType extends AbstractType
{
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
                    'class' => 'StyleInput',
                    'onchange' => ''
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
                    '' => '',
                    'Jour' => 'Jour',
                    'Semaine' => 'Semaine',
                    'Mois' => 'Mois',
                ],
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => ''
                ],
                'required' => false
            ])
            ->add('valider', ButtonType::class, [
                'label' => 'valider',
                'attr' => [
                    'class' => 'BoutonsEtapes form_non_valide',
                    'onclick' => 'buttonValidation()'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
