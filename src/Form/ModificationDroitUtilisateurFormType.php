<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModificationDroitUtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('roles', ChoiceType::class, [
                'label' => 'Droits',
                'mapped' => false,
                'choices'  => [
                    'Utilisateur' => 'Utilisateur',
                    'Administrateur' => 'Administrateur',
                    'test' => 'test',
                ],
                'required' => true
                ])
                
            /* GROUPE BOUTONS */
    
                ->add('valider', SubmitType::class, [
                    'label' => 'Enregistrer',
                    'attr' => [
                        'class' => 'BoutonsEtapes'
                    ]
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
