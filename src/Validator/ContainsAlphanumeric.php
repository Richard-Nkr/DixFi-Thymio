<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsAlphanumeric extends Constraint
{
    public $message = 'La champs "{{ string }}" contient un caractère illegal : il ne peut contenir que des lettres et de chiffres.';
}