<?php

namespace App\Form;

use App\Entity\PublicChallenge;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

/* complémentaire au ChallengeType, permet d'ajouter une correction unique au challenge à l'aide de VichUploader*/

class PublicChallengeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('fileCorrection', VichImageType::Class, array(
                'label' => 'Correction'
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => PublicChallenge::class,
        ]);
    }
}
