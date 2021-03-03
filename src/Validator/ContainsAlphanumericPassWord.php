<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class ContainsAlphanumericPassWord extends Constraint
{
    public $message = 'Le mot de passe contient un caractère illegal : il ne peut contenir que des lettres et des chiffres.';
}