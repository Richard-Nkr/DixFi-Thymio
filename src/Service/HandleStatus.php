<?php

namespace App\Service;

use App\Entity\Chat;
use App\Entity\Status;
use App\Entity\StudentGroup;
use App\Entity\Teacher;
use App\Entity\ThymioChallenge;
use App\Entity\User;
use App\Entity\UserGuest;
use App\Form\UserGuestType;
use App\Form\UserType;
use App\Repository\StatusRepository;
use App\Repository\UserGuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HandleStatus
{
    public function updateStatus(Status $status) : Status
    {

        if ($status->getStatusInt()==0){
            $status->setStatusInt(1);
            $status->setStartedAt(new \DateTime());
        }elseif ($status->getStatusInt()==1){
            $status->setStatusInt(2);
            $status->setSubmittedAt(new \DateTime());
            $status->setComment(null);
        }
        return $status;
    }
}
