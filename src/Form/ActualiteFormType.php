<?php

namespace App\Form;

use App\Entity\Actualite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ActualiteFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => 'Titre',
                'attr' => [
                    'class' => 'StyleInput'
                ]
                ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'label_attr' => [
                    'required' => $options['require_image'],
                ],
                'mapped' => false,
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => "apercu(this)",
                    'accept' => "image/*"
                ],
                'required' => $options['require_image'],
                ])
            ->add('lien', TextType::class, [
                'label' => 'Lien',
                'attr' => [
                    'class' => 'StyleInput'
                ]
                ])
            ->add('afficher', ChoiceType::class, [
                'label' => 'Afficher',
                'choices'  => [
                    'Non' => 0,
                    'Oui' => 1
                ],
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => "displayPriorite(this)",
                ]
                ])
            ->add('priorite', ChoiceType::class, [
                'label' => 'Priorité',
                'label_attr' => [
                    'id' => 'priorite',
                    'required' => false
                ],
                'choices'  => [
                    'Aucune' => 0,
                    'Secondaire' => 1,
                    'Prioritaire' => 2
                ],
                'attr' => [
                    'class' => 'StyleInput'
                ],
                'required' => false
                ])
            ->add('valider', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'BoutonsEtapes'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Actualite::class,
            'require_image' => false,
        ]);
        $resolver->setAllowedTypes('require_image', 'bool');
    }
}
