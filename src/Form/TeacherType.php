<?php

namespace App\Form;

use App\Entity\Teacher;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

//ajout du use pour utiliser le type input password de Symfony
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class TeacherType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname')
            ->add('password', PasswordType::class)
            ->add('mailTeacher')
            ->add('nameTeacher')
            ->add('firstNameTeacher')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Teacher::class,
        ]);
    }
}
