<?php

namespace App\Service;



use App\Entity\StudentGroup;
use App\Entity\Teacher;

class CreateStudentGroup
{
    public function create(StudentGroup $studentGroup, Teacher $teacher)
    {
        $studentGroup->setRoles(["ROLE_STUDENT_GROUP"]);
        $studentGroup->setCountSucceed(0);
        $studentGroup->setTeacher($teacher);
    }

}