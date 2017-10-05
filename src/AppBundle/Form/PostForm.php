<?php

namespace AppBundle\Form;

use KMS\FroalaEditorBundle\Form\Type\FroalaEditorType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, ['required' => true, 'label' => 'Title'])
            ->add('text', FroalaEditorType::class, ['required' => true, 'label' => 'Text'])
            ->add('date', DateType::class, ['required' => true, 'label' => 'Date'])
            ->add('url', TextType::class)
            ->add('is_active', CheckboxType::class, ['value' => 0, 'required' => false])
            ->add('tags', CollectionType::class, ['class' => 'AppBundle:Tag', 'choice_label' => 'title', 'multiple' => true, 'expanded' => true, 'mapped' => false])
            ->add('save', SubmitType::class, ['label' => 'Create post']);
    }
}