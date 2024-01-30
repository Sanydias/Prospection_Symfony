<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AdminSiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departement', ChoiceType::class, [
                'label' => 'Département',
                'label_attr' => [
                    'class' => 'NonDecaleLabel'
                ],
                'choices'  => [
                    '' => '',
                    '1' => 'Ain',
                    '2' => 'Aisne',
                ],
                'required' => true
                ])
            ->add('commune', ChoiceType::class, [
                'label' => 'Département',
                'label_attr' => [
                    'class' => 'NonDecaleLabel'
                ],
                'choices'  => [
                    '' => '',
                    '77270' => 'Villeparisis',
                    '77500' => 'Chelles',
                ],
                'required' => true
                ])
            ->add('lieuxdit', TextType::class, [
                'label' => 'Lieux-dit',
                'label_attr' => [
                    'class' => 'DecalerLabel'
                ],
                'attr' => [
                    'class' => 'StyleInputNomPrenom',
                    'onkeyup' => "deplaceLabel(this)"
                ], 
                'required' => true
                ])
            ->add('interethistorique', ChoiceType::class, [
                'label' => 'Interet Historique',
                'label_attr' => [
                    'class' => 'NonDecaleLabel'
                ],
                'choices'  => [
                    '' => '',
                    'Romain' => 'Romain',
                    'Galo-Romain' => 'Galo-Romain',
                ],
                'required' => true
                ])
            ->add('lien', TextType::class, [
                'label' => 'Lien',
                'label_attr' => [
                    'class' => 'DecalerLabel'
                ],
                'attr' => [
                    'class' => 'StyleInputNomPrenom',
                    'onkeyup' => "deplaceLabel(this)"
                ], 
                'required' => true
                ])
            ->add('timer', ChoiceType::class, [
                'label' => 'Timer',
                'label_attr' => [
                    'class' => 'NonDecaleLabel'
                ],
                'choices'  => [
                    'Non' => 'Non',
                    'Oui' => 'Oui'
                ],
                'required' => true
                ])
            ->add('type_timer', ChoiceType::class, [
                'label' => 'Type de Timer',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'choices'  => [
                    '' => '',
                    'Day' => 'Jour',
                    'Week' => 'Semaine',
                    'Month' => 'Mois'
                ],
                'required' => false
                ])
            ->add('temps_initial', DateType::class, [
                'label' => 'temps initial',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'StyleInput'
                ],
                'required' => false
                ])
            ->add('temps_restant', DateType::class, [
                'label' => 'temps restant',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'StyleInput'
                ],
                'required' => false
                ])
            ->add('rechercher', SubmitType::class, [
                'label' => 'Rechercher',
                'attr' => [
                    'class' => 'BoutonsEtapes form_non_valide',
                    'id' => "BoutonValider",
                    'onclick' => 'validationFormulaire()'
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
