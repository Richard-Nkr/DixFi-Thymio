<?php

namespace App\Form;

use App\Entity\Help;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HelpType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('challenge')
            ->add('contentHelp')
            ->add('numberHelp')
            //->add('groups')

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Help::class,
        ]);
    }
}
