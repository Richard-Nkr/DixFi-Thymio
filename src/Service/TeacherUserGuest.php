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

class TeacherUserGuest
{
    public function makeTeacher(UserGuest $userguest): Teacher
    {
        $teacher = new Teacher();
        $teacher->setPassword($userguest->getPassword());
        $teacher->setRoles(['ROLE_TEACHER']);
<<<<<<< HEAD
=======
        $teacher->getCreatedAt(new \DateTime('now'));
>>>>>>> feature_create_challenge
        $teacher->setFirstname($userguest->getFirstname());
        $teacher->setMail($userguest->getMail());
        $teacher->setName($userguest->getName());
        $teacher->setNickname($userguest->getNickname());
        return $teacher;
    }
}
