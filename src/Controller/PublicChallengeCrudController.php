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
