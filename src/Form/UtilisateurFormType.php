<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UtilisateurFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            /* GROUPE 3 */

                ->add('nom', TextType::class, [
                    'label' => 'Nom',
                    'label_attr' => [
                        'class' => 'DecalerLabel',
                        'required' => false
                    ],
                    'attr' => [
                        'class' => 'StyleInputNomPrenom',
                        'id' => "IdNom",
                        'onkeyup' => "deplaceLabel(this)"
                    ], 
                    'required' => false
                    ])
                ->add('prenom', TextType::class, [
                    'label' => 'Prénom',
                    'label_attr' => [
                        'class' => 'DecalerLabel',
                        'required' => false
                    ],
                    'attr' => [
                        'class' => 'StyleInputNomPrenom',
                        'id' => "IdPrenom",
                        'onkeyup' => "deplaceLabel(this)"
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
                        'id' => "IdNaissance",
                        'onchange' => 'validationFormulaire()'
                    ],
                    'required' => true
                    ])

            /* GROUPE 1 */

                ->add('email', EmailType::class, [
                    'label' => 'Email',
                    'label_attr' => [
                        'class' => 'DecalerLabel',
                    ],
                    'attr' => [
                        'class' => "StyleInput",
                        'id' => "IdEmail",
                        'onkeyup' => "deplaceLabel(this)",
                        'onchange' => "mailChange(this)",
                    ],
                    'required' => true
                    ])
                ->add('password', PasswordType::class, [
                    'label' => 'Mot de Passe',
                    'label_attr' => [
                        'class' => 'DecalerLabel'
                    ],
                    'attr' => [
                        'class' => 'StyleMotDePasse',
                        'id' => "IdMotDePasse",
                        'onkeyup' => "deplaceLabel(this)",
                        'onchange' => "verificationMotDePasse()"
                    ],
                    'required' => true,
                    ])

            /* GROUPE 2 */

                ->add('pseudo', TextType::class, [
                    'label' => 'Pseudo',
                    'label_attr' => [
                        'class' => 'DecalerLabel'
                    ],
                    'attr' => [
                        'class' => 'StyleInput',
                        'id' => "IdPseudo",
                        'onkeyup' => "deplaceLabel(this)"
                    ],
                    'required' => true
                    ])
                ->add('photodeprofil', FileType::class, [
                    'label' => 'Photo de Profil',
                    'label_attr' => [
                        'class' => 'NonDecaleLabel',
                        'required' => false
                    ],
                    'attr' => [
                        'class' => 'StyleInput',
                        'id' => "IdPP",
                        'onchange' => "apercu(this)",
                        'accept' => "image/*"
                    ],
                        'required' => false
                    ])
                    
            /* GROUPE BOUTONS */

                ->add('precedent', ButtonType::class, [
                    'label' => 'Précédent',
                    'attr' => [
                        'class' => 'BoutonsEtapes',
                        'id' => "BoutonPrecedent", 
                        'onclick' => "etape(this)",
                    ]
                ])
                ->add('suivant', ButtonType::class, [
                    'label' => 'Suivant',
                    'attr' => [
                        'class' => 'BoutonsEtapes',
                        'id' => "BoutonpSuivant", 
                        'onclick' => "etape(this)",
                    ]
                ])
                ->add('valider', SubmitType::class, [
                    'label' => 'Valider',
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
            'data_class' => Utilisateur::class,
        ]);
    }
}
