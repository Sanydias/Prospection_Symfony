<?php

namespace App\Form;

use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OubliFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

        /* GROUPE 1 */

            ->add('email', EmailType::class, [
                'label' => 'Email',
                'label_attr' => [
                    'class' => 'DecalerLabel',
                ],
                'attr' => [
                    'class' => "StyleInput",
                    'onkeyup' => "deplaceLabel(this)",
                    'onchange' => "mailChange(this)"
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
                    'onkeyup' => "deplaceLabel(this)",
                    'onchange' => "verificationMotDePasse()"
                ],
                'required' => true,
                ])
                
        /* GROUPE BOUTONS */


            ->add('precedent', ButtonType::class, [
                'label' => 'Précédent',
                'attr' => [
                    'class' => 'BoutonsEtapes',
                    'onclick' => "etape(this)",
                ]
            ])
            ->add('suivant', ButtonType::class, [
                'label' => 'Suivant',
                'attr' => [
                    'class' => 'BoutonsEtapes',
                    'onclick' => "etape(this)",
                ]
            ])
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
