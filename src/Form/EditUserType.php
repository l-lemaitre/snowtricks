<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Regex;

class EditUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'options' => ['attr' => ['class' => 'password-field']],
                'first_options'  => [
                    'label' => 'Password',
                    'constraints' => [
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
                    'label' => 'Confirm password'
                ],
                'invalid_message' => 'Password fields must match.',
                'mapped' => false,
                'required' => false
            ])
            ->add('lastname', TextType::class, [
                'label' => 'Lastname',
                'required' => false,
                'empty_data' => '',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Firstname',
                'required' => false,
                'empty_data' => '',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('profile_picture', FileType::class, [
                'label' => 'Profile picture',
                'mapped' => false,
                'required' => false,
                'help' => 'Accepted formats: .avif, .gif, .jpeg, .jpg, .png, .svg, .webp',
                'constraints' => [
                    new File([
                        'maxSize' => '3072k',
                        'mimeTypes' => [
                            'image/*'
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file.'
                    ])
                ]
            ])
            ->add('validate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class
        ]);
    }
}
