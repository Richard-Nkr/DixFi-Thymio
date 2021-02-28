<?php

namespace App\Form;

use App\Entity\PrivateChallenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PrivateChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name')
            ->add('difficulty')
            ->add('description')
            ->add('duration')
            ->add('role')
            ->add('solutionPath')
            ->add('createdAt')
            ->add('deletedAt')
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
