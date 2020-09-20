<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MentionsController extends AbstractController
{
    /**
     * @Route("/mentions", name="mentions_index")
     */
    public function index()
    {
        return $this->render('mentions/index.html.twig', [
            'controller_name' => 'MentionsController',
        ]);
    }
}
