<?php

namespace App\Controller\Admin;

use App\Entity\Logement;
use App\Entity\Users;
use App\Form\EditUserType;
use App\Form\LogementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;
use App\Repository\UsersRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{

    /**
     * @var LogementRepository
     */
    public function __construct(LogementRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/acces", name="logement_index")
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function index(): Response
    {
        $logements = $this->repository->findAll();
        return $this->render('admin/admin.html.twig', [
            'logements' => $logements,
        ]);
    }
    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/logement", name="logement_create")
     */
    public function new(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
        $logement = new Logement();
        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->persist($logement);
            $this->em->flush();
            $this->addFlash('success', 'bien creer');

            return $this->redirectToRoute('admin.logement.index');
        }

        return $this->render('admin/new.logement.html.twig', [
            'logement' => $logement,
            'form' => $form->createView()
        ]);
    }
    /**
     * @Route("/admin/logement/{id}", name="logement_edit", methods="GET|POST")
     * @param Logement $logement
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function edit(Logement $logement, Request $request)
    {

        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($logement);
            $entityManager->flush();

            $this->addFlash('success', 'bien modifié');

            return $this->redirectToRoute('admin_logement_index');
        }

        return $this->render('admin/edit.html.twig', [
            'logement' => $logement,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/logement/{id}", name="logement_delete", methods="DELETE")
     * @param Logement $logement
     * @return Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function delete(Logement $logement, Request $request)
    {

        $this->em->remove($logement);
        $this->em->flush();
        $this->addFlash('success', 'bien supprimé');


        return $this->redirectToRoute('admin.logement.index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/utilisateurs", name="utilisateurs")
     */
    public function usersList(UsersRepository $users)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("/utilisateurs/modifier/{id}", name="modifier_utilisateur")
     */
    public function editUser(Users $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
}
