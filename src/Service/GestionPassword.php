<?php

namespace App\Service;

use App\Entity\Chat;
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

class GestionPassword
{
    public function createHashPassword(UserGuest $userguest)
    {
        $pass = password_hash($userguest->getPassword(), PASSWORD_DEFAULT);
        $userguest->setPassword($pass);
    }
}