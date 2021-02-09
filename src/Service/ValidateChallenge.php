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
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ValidateChallenge
{
    public function handleStatus(Status $status)
    {
        $status->setStatusInt(3);
        $status->setFinishedAt(new \DateTime());
    }

    public function handleStudentGroup(Status $status)
    {
        $studentGroup = $status->getStudentGroup();
        $studentGroup->setCountSucceed($studentGroup->getCountSucceed()+1);
    }
}