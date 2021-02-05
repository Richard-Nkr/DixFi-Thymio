<?php

namespace App\Form;

use App\Entity\UserGuest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserGuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname')
            ->add('password', PasswordType::class)
            ->add('mail')
            ->add('name')
            ->add('firstName')
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Enseignant' => 'teacher',
                    'Utilisateur simple' => 'user_guest',
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGuest::class,
        ]);
    }
}
