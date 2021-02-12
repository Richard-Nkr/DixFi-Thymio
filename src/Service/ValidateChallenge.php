<?php

namespace App\Service;

use App\Entity\Chat;
use App\Entity\Status;
use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\UserGuest;
use App\Form\UserGuestType;
use App\Form\UserType;
use App\Repository\UserGuestRepository;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidateChallenge
{
    public function handleStatus(Status $status, bool $validate)
    {
        if($validate){
            $status->setStatusInt(3);
            $status->setFinishedAt(new \DateTime());
        }else{
            $status->setStatusInt(1);
            $status->setFinishedAt(NULL);
        }

    }

    public function handleStudentGroup(Status $status, bool $validate)
    {
        if($validate) {
            $studentGroup = $status->getStudentGroup();
            $studentGroup->setCountSucceed($studentGroup->getCountSucceed() + 1);
        }else{
            $studentGroup = $status->getStudentGroup();
            if ($status->getStatusInt()==3) {
                $studentGroup->setCountSucceed($studentGroup->getCountSucceed() - 1);
                $status->setFinishedAt(NULL);
            }
            $status->setSubmittedAt(NULL);

        }
    }
}