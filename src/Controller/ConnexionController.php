<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class ConnexionController extends AbstractController
{
    /**
     * @Route("/connexion", name="connexion_index")
     */
    public function login(Request $request, AuthenticationUtils $authenticationUtils)
    {

        // au cas d'erreur de login
        $error = $authenticationUtils->getLastAuthenticationError();

        // dernier username renter par lutilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('connexion/index.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }
}
