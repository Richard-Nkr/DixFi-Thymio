<?php

namespace App\Service;


use App\Entity\User;

class GestionPassword
{
    public function createHashPassword(User $user)
    {
        $pass = password_hash($user->getPassword(), PASSWORD_DEFAULT);
        $user->setPassword($pass);
    }
}