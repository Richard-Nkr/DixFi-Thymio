<?php


namespace App\Validator;


use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedTypeException;
use Symfony\Component\Validator\Exception\UnexpectedValueException;

class ContainsNumberAndLetterValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        if (!$constraint instanceof ContainsNumberAndLetter) {
            throw new UnexpectedTypeException($constraint, ContainsNumberAndLetter::class);
        }


        if (null === $value || '' === $value) {
            return;
        }

        if (!is_string($value)) {
            throw new UnexpectedValueException($value, 'string');
        }

        //Vérifie que la chaine contient bien au moins une lettre et un chiffre
        if (!preg_match('/^.*[0-9]+.*$/', $value, $matches) || !preg_match('/^.*[a-zA-Z]+.*$/', $value, $matches)) {
            $this->context->buildViolation($constraint->message)
                ->setParameter('{{ string }}', $value)
                ->addViolation();
        }

    }
}