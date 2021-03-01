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

class UpdateTeacher
{
    public function update(Teacher $teacher, Teacher $teacherBis): Teacher
    {
        $teacherBis->setPassword($teacher->getPassword());
        $teacherBis->getCreatedAt(new \DateTime('now'));

        $teacherBis->setFirstname($teacher->getFirstname());
        $teacherBis->setMail($teacher->getMail());
        $teacherBis->setName($teacher->getName());
        $teacherBis->setNickname($teacher->getNickname());
        return $teacherBis;
    }
}