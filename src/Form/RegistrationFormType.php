<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class, [
                'label' => 'Username',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'Accept the conditions',
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You have to accept our terms of service.'
                    ])
                ]
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password'
                    ]
                ],
                'first_options' => [
                    'label' => 'Password',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter your username.'
                        ]),
                        new NotNull(),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096
                        ]),
                        new Regex([
                            'pattern' => '/^[0-9A-Za-z]{8,}$/',
                            'message' => 'The Password is invalid. It must contain at least 8 alphanumeric characters and contain no accents or special characters.'
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm password',
                    'constraints' => [
                        new NotBlank(),
                        new NotNull()
                    ]
                ],
                'invalid_message' => 'Password fields must match.',
                // Instead of being set onto the object directly,
                // this is read and encoded in the controller
                'mapped' => false
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
