<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname', TextType::class, [
                'disabled' => true,
                'label' => 'Nome'
            ])
            ->add('lastname', TextType::class, [
                'disabled' => true,
                'label' => 'Cognome'
            ])
            ->add('email', EmailType::class, [
                'disabled' => true
            ])
            ->add('old_password', PasswordType::class, [
                'label' => 'Password attuale',
                'mapped' => false,
                'attr' => [
                    'placeholder' => 'Inserire la password attuale'
                ]
            ])
            ->add('new_password', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false,
                'invalid_message' => 'Le due password devono corrispondere',
                'required' => true,
                'first_options' => [
                    'label' => 'Nuova password',
                    'attr' => [
                        'placeholder' => 'Inserisci la nuova password'
                    ]
                ],
                'second_options' => [
                    'label' => 'Conferma nuova  password',
                    'attr' => [
                        'placeholder' => 'Conferma la nuova passsord'
                    ]
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Aggiorna password'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
