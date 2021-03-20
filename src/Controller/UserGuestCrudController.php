<?php

namespace App\Controller;

use App\Entity\UserGuest;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserGuestCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return UserGuest::class;
    }
}
