<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ModificationUtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        /* GROUPE 3 */

            ->add('nom', TextType::class, [
                'label' => 'Nom',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'attr' => [
                    'class' => 'StyleInputNomPrenom',
                ], 
                'required' => false
                ])
            ->add('prenom', TextType::class, [
                'label' => 'Prénom',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                    'required' => false
                ],
                'attr' => [
                    'class' => 'StyleInputNomPrenom',
                ], 
                'required' => false
                ])
            ->add('sexe', ChoiceType::class, [
                'label' => 'Sexe',
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
            ->add('datedenaissance', DateType::class, [
                'label' => 'Date de Naissance',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                ],
                'widget' => 'single_text',
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => 'validationFormulaire()'
                ],
                'required' => true
                ])

        /* GROUPE 1 */

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'NonDecaleLabel',
                ],
                'attr' => [
                    'class' => "StyleInput",
                    'onchange' => "mailChange(this)"
                ],
                'required' => true
                ])
            ->add('pseudo', TextType::class, [
                'label' => 'Pseudo',
                'label_attr' => [
                    'class' => 'NonDecaleLabel'
                ],
                'attr' => [
                    'class' => 'StyleInput',
                ],
                'required' => true
                ])
            ->add('photodeprofil', FileType::class, [
                'mapped' => false,
                'attr' => [
                    'class' => 'StyleInput',
                    'onchange' => "apercu(this)",
                    'accept' => "image/*"
                ],
                    'required' => false
                ])
                
        /* GROUPE BOUTONS */

            ->add('valider', SubmitType::class, [
                'label' => 'Valider',
                'attr' => [
                    'class' => 'BoutonsEtapes',
                    'onclick' => 'validationFormulaire()'
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
