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
                'label' => 'Catégorie',
                'choice_label' => 'title',
                'empty_data' => '',
                'constraints' => [
                    new NotNull()
                ]
            ])
            ->add('title', TextType::class, [
                'label' => 'Titre',
                'empty_data' => '',
                'constraints' => [
                    new NotBlank(),
                    new NotNull()
                ]
            ])
            ->add('contents', TextareaType::class, [
                'label' => 'Contenu',
                'empty_data' => '',
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
                'empty_data' => '',
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
