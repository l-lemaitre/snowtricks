<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Image;
use App\Entity\Trick;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class TrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Catégorie',
                'choice_label' => 'title',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Image(s)',
                'mapped' => false,
                'multiple' => true,
                'help' => 'Formats acceptés : .gif, .jpeg, .jpg, .png, .svg',
                'constraints' => [
                    new All([
                        'constraints' => [
                            new File([
                                'maxSize' => '1024k',
                                'mimeTypes' => [
                                    'image/*'
                                ],
                                'mimeTypesMessage' => 'Please upload a valid image file.',
                            ])
                        ]
                    ]),
                    new NotNull()
                ]
            ])
            ->add('video', TextType::class, [
                'label' => 'Vidéo',
                'mapped' => false,
                'required' => false
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'constraints' => [
                    new NotBlank([
                        'message' => 'Test.'
                    ]),
                    new NotNull([
                        'message' => 'Test.'
                    ])
                ]
            ])
            ->add('contents', TextareaType::class, [
                'label' => 'Contenu',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('slug', TextType::class, [
                'label' => 'Permalien',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('published', ChoiceType::class, [
                'choices'  => [
                    'Oui' => true,
                    'Non' => false
                ],
                'label' => 'Publié',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('Valider', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }
}
