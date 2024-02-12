<?php

namespace App\Form;

use App\Entity\Site;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RechercheSiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('timer', CheckboxType::class, [
                'label' => 'Durée Limité',
                'label_attr' => [
                    'class' => 'StyleCheckboxlabel',
                    'required' => false
                ],
                'attr' => [
                    'class' => 'StyleCheckboxInput'
                ],
                'required' => false
            ])
            // ->add('rechercher', SubmitType::class, [
            //     'label' => 'Rechercher',
            //     'attr' => [
            //         'class' => 'BoutonsEtapes'
            //     ]
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Site::class,
        ]);
    }
}
