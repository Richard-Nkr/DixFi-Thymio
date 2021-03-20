<?php

namespace App\Service;


use App\Entity\Teacher;
use App\Entity\UserGuest;

class TeacherGenerator
{
    public function generate(UserGuest $userguest): Teacher
    {
        $teacher = new Teacher();
        $teacher->setPassword($userguest->getPassword());
        $teacher->setRoles(['ROLE_TEACHER']);

        $teacher->setFirstname($userguest->getFirstname());
        $teacher->setMail($userguest->getMail());
        $teacher->setName($userguest->getName());
        $teacher->setNickname($userguest->getNickname());
        return $teacher;
    }
}
