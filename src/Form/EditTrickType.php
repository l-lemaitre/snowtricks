<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Trick;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class EditTrickType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
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
            ->add('title', TextType::class, [
                'label' => 'Title',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('contents', TextareaType::class, [
                'label' => 'Contents',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
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

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Trick::class
        ]);
    }
}
