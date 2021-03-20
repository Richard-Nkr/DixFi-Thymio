<?php

namespace App\Form;

use App\Entity\Challenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => ['maxlength' => 30]
                ]
            )
            ->add('description', TextareaType::class)
            ->add('difficulty', ChoiceType::class, [
                'choices' => [
                    'Facile' => 'easy',
                    'Moyen' => 'medium',
                    'Difficile' => 'hard',
                    'Extrême' => 'extreme',
                ],
            ])
            ->add('duration', TextType::class)
            ->add('role', ChoiceType::class, [
                'choices' => [
                    'Public : Disponible pour tout le monde' => "ROLE_PUBLIC_CHALLENGE",
                    'Privé : Disponible uniquement pour ma classe' => "ROLE_PRIVATE_CHALLENGE",
                ],
                'expanded' => true,
                'multiple' => false,
            ])
            ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Challenge::class,
        ]);
    }
}
