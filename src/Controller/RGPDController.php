<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class RGPDController extends AbstractController
{
    /**
     * @Route("/rgpd", name="rgpd_index")
     */
    public function index()
    {
        return $this->render('rgpd/index.html.twig', [
            'controller_name' => 'RGPDController',
        ]);
    }
}
