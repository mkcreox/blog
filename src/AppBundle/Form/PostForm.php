<?php

namespace AppBundle\Form;

use AppBundle\Entity\Tag;
use AppBundle\Repository\TagRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control top-10',
                    'placeholder' => 'Title of Blog post'
                ]
            ])

            ->add('text', TextareaType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'form-control top-10',
                    'placeholder' => 'Write your Blog content here...'
                ]
            ])

            ->add('date', DateType::class, [
                'required' => true,
                'label' => false,
                'attr' => [
                    'class' => 'created-date top-10'
                ]
            ])

            ->add('url', TextType::class, [
                'label' => false,
                'attr' => [
                    'class' => 'form-control top-10',
                    'placeholder' => 'Blog post URL'
                ]])

            ->add('is_active', CheckboxType::class, [
                'value' => 0,
                'required' => false,
                'attr' => [
                    'class' => 'top-10-active'
                ]
            ])

            ->add('tags', EntityType::class, [
                'class' => 'AppBundle:Tag',
                'choice_label' => 'title',
                'multiple' => true,
                'expanded' => true,
                'mapped' => false,
                'attr' => [
                    'class' => 'checkbox pull-left top-10-active',
                    'style' => 'margin-left: 5px'
                ]
            ])

            ->add('save', SubmitType::class, [
                'label' => 'Save',
                'attr' => [
                    'class' => 'btn btn-success pull-right',
                    'style' => 'margin-top: 20px'
                ]
            ]);
    }
}