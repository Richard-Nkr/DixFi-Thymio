<?php

namespace App\Controller;

use App\Entity\PublicChallenge;
use App\Entity\Teacher;
use App\Entity\User;
use App\Entity\UserGuest;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);
        //faire en sorte que la page affiché soit directement le menu admin du PublicChallenge
        return $this->redirect($routeBuilder->setController(PublicChallengeCrudController::class)->generateUrl());
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('DixFi Thymio');
    }

    public function configureMenuItems(): iterable
    {
        //ajout des differentes entités au menu admin
        yield MenuItem::linkToCrud('PublicChallenge', 'fa fa-user', PublicChallenge::class);
        yield MenuItem::linkToCrud('UserGuest', 'fa fa-user', UserGuest::class);
        yield MenuItem::linkToCrud('User', 'fa fa-user', User::class);
        yield MenuItem::linkToCrud('Teacher', 'fa fa-user', Teacher::class);
    }
}
