<?php

namespace App\Controller;

use App\Repository\LogementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AcceuilController extends AbstractController
{

    /**
     * @Route("/", name="acceuil_index")
     */
    public function index(LogementRepository $repository): Response
    {
        $logements = $repository->findLatest();
        $nouveautes = $repository->findBy([], ['created_at' => 'desc'], 3);

        return $this->render('homepage/index.html.twig', [
            'logements' => $logements,
            'nouveautes' => $nouveautes
        ]);
    }
}
