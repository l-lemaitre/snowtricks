<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\All;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class AddTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'label' => 'Category',
                'choice_label' => 'title',
                'empty_data' => '',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('image', FileType::class, [
                'label' => 'Picture(s)',
                'mapped' => false,
                'required' => false,
                'multiple' => true,
                'help' => 'Accepted formats: .avif, .gif, .jpeg, .jpg, .png, .svg, .webp',
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
                    ])
                ]
            ])
            ->add('video', CollectionType::class, [
                'entry_type' => UrlType::class,
                'label' => false,
                'mapped' => false,
                'required' => false,
                'allow_add' => true,
                'by_reference' => false,
                'allow_delete' => true
            ])
            ->add('title', TextType::class, [
                'label' => 'Title',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('contents', TextareaType::class, [
                'label' => 'Contents',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('published', ChoiceType::class, [
                'choices'  => [
                    'Yes' => true,
                    'No' => false
                ],
                'label' => 'Published',
                'empty_data' => '',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('validate', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }
}
