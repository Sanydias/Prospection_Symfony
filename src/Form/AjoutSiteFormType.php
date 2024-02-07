<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AjoutSiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('departement')
            ->add('commune')
            ->add('lieuxdit', TextType::class, [
                'label' => 'Lieux-dit',
                'attr' => [
                    'class' => '',
                    'onchange' => ''
                ]
            ])
            ->add('interethistorique', TextType::class, [
                'label' => 'Intérêt Historique',
                'attr' => [
                    'class' => '',
                    'onchange' => ''
                ]
            ])
            ->add('lien', TextType::class, [
                'label' => 'Lien',
                'attr' => [
                    'class' => '',
                    'onchange' => ''
                ]
            ])
            ->add('timer', ChoiceType::class, [
                'label' => 'timer',
                'choices'  => [
                    'Non' => 0,
                    'Oui' => 1,
                ],
                'attr' => [
                    'class' => 'BoutonsEtapes form_non_valide',
                    'onclick' => 'validationFormulaire()'
                ]
            ])
            ->add('typetimer', ChoiceType::class, [
                'label' => 'temps restant',
                'choices'  => [
                    '' => '',
                    'Jour' => 'Jour',
                    'Semaine' => 'Semaine',
                    'Mois' => 'Mois',
                ],
                'attr' => [
                    'class' => '',
                    'onchange' => ''
                ]
            ])
            ->add('valider', SubmitType::class, [
                'label' => 'valider',
                'attr' => [
                    'class' => 'BoutonsEtapes form_non_valide',
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
