<?php

namespace App\Service;

use App\Entity\UserGuest;

class UpdateUserGuest
{
    public function update(UserGuest $userGuest, UserGuest $userGuestBis): UserGuest
    {
        $userGuestBis->setPassword($userGuest->getPassword());

        $userGuestBis->setFirstname($userGuest->getFirstname());
        $userGuestBis->setMail($userGuest->getMail());
        $userGuestBis->setName($userGuest->getName());
        $userGuestBis->setNickname($userGuest->getNickname());
        return $userGuestBis;
    }
}