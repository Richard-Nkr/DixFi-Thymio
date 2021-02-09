<?php

namespace App\Service;

use App\Entity\Chat;
use App\Entity\Status;
use App\Entity\StudentGroup;
use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\UserGuest;
use App\Form\UserGuestType;
use App\Form\UserType;
use App\Repository\TeacherRepository;
use App\Repository\UserGuestRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CreateStudentGroup
{
    public function create(StudentGroup $studentGroup, Teacher $teacher)
    {
        $studentGroup->setRoles(["ROLE_STUDENT_GROUP"]);
        $studentGroup->setCountSucceed(0);
        $studentGroup->setTeacher($teacher);
        $studentGroup->setChat($teacher->getChat());
    }

}