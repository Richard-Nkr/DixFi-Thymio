<?php

namespace App\Form;

use App\Entity\StudentGroup;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StudentGroupType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname')
            ->add('createdAt')
            ->add('deletedAt')
            ->add('password')
            ->add('role')
            ->add('countSucceed')
            ->add('teacher')
            ->add('helps')
            ->add('challenges')
            ->add('chat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => StudentGroup::class,
        ]);
    }
}
