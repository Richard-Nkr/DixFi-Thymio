<?php

namespace App\Form;

use App\Entity\PrivateChallenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrivateChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('difficulty', TextType::class)
            ->add('description', TextType::class)
            ->add('duration', TextType::class)
            ->add('role', TextType::class)
            ->add('solutionPath', TextType::class)
            ->add('createdAt', \DateTime::class)
            ->add('groups')
            ->add('teacher')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PrivateChallenge::class,
        ]);
    }
}