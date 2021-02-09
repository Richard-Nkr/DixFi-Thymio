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

class CreateChat
{
    public function create(Teacher $teacher): Chat
    {
        $chat = new Chat();
        $chat->setTeacher($teacher);
        $teacher->setChat($chat);
        return $chat;
    }
}

