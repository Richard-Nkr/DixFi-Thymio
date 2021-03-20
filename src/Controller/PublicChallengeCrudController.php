<?php

namespace App\Controller;

use App\Entity\PublicChallenge;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PublicChallengeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PublicChallenge::class;
    }

}
