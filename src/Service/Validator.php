<?php


namespace App\Service;


use App\Entity\UserGuest;
use App\Services\MailerService;
use App\Validator\ContainsAlphanumeric;
use App\Validator\ContainsAlphanumericPassWord;
use App\Validator\ContainsNumberAndLetterValidator;
use App\Validator\ContainsNumberAndLetter;
use Doctrine\ORM\EntityRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Notifier\Notification\Notification;
use Symfony\Component\Notifier\NotifierInterface;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;

class Validator
{


    /**
     * @param UserGuest $userguest
     * @return ConstraintViolationListInterface
     */
    public function PassWordValidator(UserGuest $userguest): ConstraintViolationListInterface
    {
        $pw = $userguest->getPassword();
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
     * @param UserGuest $userguest
     * @return ConstraintViolationListInterface
     */
    public function FieldsValidator(UserGuest $userguest) : ConstraintViolationListInterface
    {
        $nn = $userguest->getNickname();
        $name = $userguest->getName();
        $fname = $userguest->getFirstname();
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

}