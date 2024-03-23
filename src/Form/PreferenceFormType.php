<?php

namespace App\Form;

use App\Entity\Localisation;
use App\Entity\Preference;
use App\Entity\Utilisateur;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PreferenceFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('codedepartement', EntityType::class,[
                'class' => Localisation::class,
                'choice_label' => 'codedepartement',
                'mapped' => false
            ])
            ->add('nomcommunecomplet', EntityType::class,[
                'class' => Localisation::class,
                'choice_label' => 'nomcommunecomplet',
                'mapped' => false
            ])
            ->add('enregistrer', SubmitType::class, [
                'label' => 'enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Preference::class,
        ]);
    }
}
