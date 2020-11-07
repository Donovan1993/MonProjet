<?php

namespace App\Controller\Admin;

use App\Entity\Articles;
use App\Entity\Categories;
use App\Entity\Commentaires;
use App\Entity\Logement;
use App\Entity\Users;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;


class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin_index")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('MOGO');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Tableau de Bord', 'fa fa-home'),

            MenuItem::section('LOGEMENT'),
            MenuItem::linkToCrud('Logement', 'fa fa-tags', Logement::class),
            MenuItem::section('ARTICLES'),
            MenuItem::linkToCrud('Articles', 'fa fa-file-text', Articles::class),
            MenuItem::linkToCrud('Commentaires', 'fa fa-comment', Commentaires::class),
            MenuItem::section('UTILISATEURS'),
            MenuItem::linkToCrud('Users', 'fa fa-user', Users::class),


        ];
    }
}
