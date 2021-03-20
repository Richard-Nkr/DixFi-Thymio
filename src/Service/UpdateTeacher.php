<?php

namespace App\Service;

use App\Entity\Teacher;

class UpdateTeacher
{
    public function update(Teacher $teacher, Teacher $teacherBis): Teacher
    {
        $teacherBis->setPassword($teacher->getPassword());

        $teacherBis->setFirstname($teacher->getFirstname());
        $teacherBis->setMail($teacher->getMail());
        $teacherBis->setName($teacher->getName());
        $teacherBis->setNickname($teacher->getNickname());
        return $teacherBis;
    }
}