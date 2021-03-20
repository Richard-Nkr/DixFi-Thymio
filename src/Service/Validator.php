<?php


namespace App\Service;


use App\Entity\User;
use App\Entity\UserGuest;
use App\Validator\ContainsAlphanumeric;
use App\Validator\ContainsAlphanumericPassWord;
use App\Validator\ContainsNumberAndLetter;
use phpDocumentor\Reflection\Types\Array_;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class Validator
{


    /**
     * @param User $user
     * @return ConstraintViolationListInterface
     */
    public function PassWordValidator(User $user): ConstraintViolationListInterface
    {
        $pw = $user->getPassword();
        //La confirmation de mpd ? getQuoi ?
        $validator = Validation::createValidator();
        $violations = $validator->validate($pw, [
            new Length(['min' => 6]),
            new ContainsNumberAndLetter(),
            new ContainsAlphanumericPassWord()
        ]);
        return $violations;
    }

    /**
     * @param User $user
     * @return ConstraintViolationListInterface
     */
    public function FieldsValidator(User $user) : ConstraintViolationListInterface
    {
        $nn = $user->getNickname();
        $name = $user->getName();
        $fname = $user->getFirstname();
        $validator = Validation::createValidator();
        $violations1 = $validator->validate($nn, [
            new Length(['max' => 20]),
            new ContainsAlphanumeric()
        ]);
        $violations2 = $validator->validate($name, [
            new Length(['max' => 20]),
            new ContainsAlphanumeric()
        ]);
        $violations3 = $validator->validate($fname, [
            new Length(['max' => 20]),
            new ContainsAlphanumeric()
        ]);
        $violations1->addAll($violations2);
        $violations1->addAll($violations3);
        return $violations1;
    }

    public function listViolations(UserGuest $userguest)
    {
        $violations = $this->PassWordValidator($userguest);
        $violations->addAll($this->FieldsValidator($userguest));
        return $violations;
    }

    /**
    public function mail($doctrine, $mail) : bool
    {
        $res = $doctrine
            ->getRepository('App:UserGuest')
            ->findOneBy(['mail' => $mail]);
        if ($res === Null)
        {
            return False;
        }
        return True;
    }
     **/

}