<?php

namespace App\Service;

use App\Entity\Status;
use App\Entity\UserGuestStatus;

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

    public function updateStatusUserGuest(UserGuestStatus $userGuestStatus) : UserGuestStatus
    {

        if ($userGuestStatus->getStatusInt()==0){
            $userGuestStatus->setStatusInt(1);
            $userGuestStatus->setStartedAt(new \DateTime());
        }elseif ($userGuestStatus->getStatusInt()==1){
            $userGuestStatus->setStatusInt(2);
        }
        return $userGuestStatus;
    }

}
