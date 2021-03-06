<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsNumberAndLetter extends Constraint
{
    public $message = 'Le mot de passe doit contenir au moins un chiffre et une lettre.';
}