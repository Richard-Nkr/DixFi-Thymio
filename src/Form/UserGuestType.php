<?php

namespace App\Form;

use App\Entity\UserGuest;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

class UserGuestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nickname', TextType::class)
            ->add('password', PasswordType::class, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                ],
            ])
            ->add('mail', EmailType::class)
            ->add('name', TextType::class)
            ->add('firstName', TextType::class)
            ->add('roles', ChoiceType::class, [
                'constraints'=> [
                    new Assert\Count([
                        'min' => 1,
                        'max' => 1,
                    ]),
                ],
                'choices' => [
                    'Enseignant' => 'ROLE_TEACHER',
                    'Utilisateur simple' => 'ROLE_USER_GUEST'
                ],
                'expanded'=>true,
                'multiple' => true
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => UserGuest::class,
        ]);
    }
}
