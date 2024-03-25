<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('sujet', TextType::class, [
                'label' => 'Sujet',
                'label_attr' => [
                    'class' => 'DecalerLabel'
                ],
                'attr' => [
                    'class' => 'StyleInput',
                    'onkeyup' => 'deplaceLabel(this)'
                ]
            ])
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'label_attr' => [
                    'class' => 'DecalerLabel'
                ],
                'attr' => [
                    'class' => 'StyleInput',
                    'onkeyup' => 'deplaceLabel(this)'
                ]
            ])
            ->add('envoyer', ButtonType::class, [
                'label' => 'Envoyer',
                'attr' => [
                    'class' => 'BoutonValider',
                    'onclick' => 'sendMail()'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
