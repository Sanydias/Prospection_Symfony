<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheSiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departement', ChoiceType::class, [
                'label' => 'Département',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'choices'  => [
                    '' => '',
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
                'required' => false
                ])
            ->add('commune', ChoiceType::class, [
                'label' => 'Commune',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'choices'  => [
                    '' => '',
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
                'required' => false
                ])
            ->add('lieuxdit', ChoiceType::class, [
                'label' => 'Lieux-dit',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'choices'  => [
                    '' => '',
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
                ],
                'required' => false
                ])
            ->add('interethistorique', ChoiceType::class, [
                'label' => 'Intrêt Historique',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'choices'  => [
                    '' => '',
                    'Homme' => 'Homme',
                    'Femme' => 'Femme',
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
