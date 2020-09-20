<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="user_registration")
     */
    public function registerUsers(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {

        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);

        //on gere la soumission la avec la methode post 
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            echo "<h2> Vous etes maintenant inscrit, rendez-vous sur la page de connexion !</h2>";
            //on encode le mdp 
            $password = $passwordEncoder->encodePassword($user, $user->getPlainpassword());
            $user->setPassword($password);

            //on sauvegarde ke User
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('acceuil_index');
        }

        return $this->render('registration/index.html.twig', array('form' => $form->createView()));
    }
}
