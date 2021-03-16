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

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
