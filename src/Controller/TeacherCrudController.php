<?php

namespace App\Controller;

use App\Entity\Teacher;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class TeacherCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Teacher::class;
    }

}
