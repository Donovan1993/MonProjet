<?php

namespace App\Controller\Admin;

use App\Entity\Logement;
use App\Form\LogementType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\LogementRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
     * @Route("/admin", name="admin.logement.index")
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
     * @Route("/admin/logement", name="admin.logement.create")
     */
    public function new(Request $request)
    {
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
     * @Route("/admin/logement/{id}", name="admin.logement.edit", methods="GET|POST")
     * @param Logement $logement
     * @return Symfony\Component\HttpFoundation\Response
     */
    public function edit(Logement $logement, Request $request)
    {

        $form = $this->createForm(LogementType::class, $logement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'bien modifié');

            return $this->redirectToRoute('admin.logement.index');
        }

        return $this->render('admin/edit.html.twig', [
            'logement' => $logement,
            'form' => $form->createView()
        ]);
    }


    /**
     * @Route("/admin/logement/{id}", name="admin.logement.delete", methods="DELETE")
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
}
