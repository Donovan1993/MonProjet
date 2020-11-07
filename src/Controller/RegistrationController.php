<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\RegistrationFormType;
use App\Repository\UsersRepository;
use App\Security\LoginFormAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/inscription", name="user_registration")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, LoginFormAuthenticator $authenticator, \Swift_Mailer $mailer): Response
    {
        $user = new Users();
        $form = $this->createForm(RegistrationFormType::class, $user);
        //on gere la soumission la avec la methode post 
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash('message', 'Vous etes inscrits, a tout de suite');
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            // On génère un token et on l'enregistre
            $user->setActivationToken(md5(uniqid()));
            //on sauvegarde ke User
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
            return $this->redirectToRoute('acceuil_index');
            // On crée le message
            $message = (new \Swift_Message('Nouveau contact'))
                // On attribue l'expéditeur
                ->setFrom('donovan.tchume@gmail.com')
                // On attribue le destinataire
                ->setTo($user->getEmail())
                // On crée le texte avec la vue
                ->setBody(
                    $this->renderView(
                        'emails/activation.html.twig',
                        ['token' => $user->getActivationToken()]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/index.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("/activation/{token}", name="activation")
     */
    public function activation($token, UsersRepository $users)
    {
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $user = $users->findOneBy(['activation_token' => $token]);

        // Si aucun utilisateur n'est associé à ce token
        if (!$user) {
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }

        // On supprime le token
        $user->setActivationToken(null);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();

        // On génère un message
        $this->addFlash('message', 'Utilisateur activé avec succès');

        // On retourne à l'accueil
        return $this->redirectToRoute('accueil');
    }
}
