<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class ChangePasswordFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => [
                    'attr' => [
                        'autocomplete' => 'new-password'
                    ]
                ],
                'first_options' => [
                    'label' => 'New Password',
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Please enter a password.'
                        ]),
                        new NotNull(),
                        new Length([
                            'min' => 6,
                            'minMessage' => 'Your password must be at least {{ limit }} characters long.',
                            // max length allowed by Symfony for security reasons
                            'max' => 4096
                        ]),
                        new Regex([
                            'pattern' => '/^[0-9A-Za-z-_]{8,}$/',
                            'message' => 'The Password is invalid. It must contain at least 8 alphanumeric characters and contain no accents or special characters except "-" or "_".'
                        ])
                    ]
                ],
                'second_options' => [
                    'label' => 'Confirm the new password',
                    'constraints' => [
                        new NotBlank(),
                        new NotNull()
                    ]
                ],
                'invalid_message' => 'Password fields must match.',
                'mapped' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
