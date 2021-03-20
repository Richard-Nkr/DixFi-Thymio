<?php

namespace App\Service;


use App\Entity\Status;

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