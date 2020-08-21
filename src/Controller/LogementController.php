<?php

namespace App\Controller;

use App\Entity\Logement;
use App\Entity\LogementSearch;
use App\Form\LogementSearchType;
use App\Repository\LogementRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LogementController extends AbstractController
{
    /**
     * @var LogementRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(LogementRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/logement", name="logement_index")
     */
    public function index(Request $request, PaginatorInterface $paginator) // Nous ajoutons les paramètres requis
    {
        //permet de creer entité pour faire les recherches filtres
        $search = new LogementSearch();
        $form = $this->createForm(LogementSearchType::class, $search);
        $form->handleRequest($request);

        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Logement::class)->findBy([], ['created_at' => 'desc']);
        $logements = $paginator->paginate(
            $this->repository->findAllVisible($search),
            //$donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('logement/index.html.twig', [
            'logements' => $logements,
            'form' => $form->createView()

        ]);
    }

    /**
     * @Route("/logement/{slug}-{id}", name="logement_show", requirements={"slug":"[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Logement $logement, string $slug): Response
    {
        if ($logement->getSlug() !== $slug) {
            return $this->redirectToRoute('logement_show', [
                'id' => $logement->getId(),
                'slug' => $logement->getSlug()
            ], 301);
        }

        return $this->render('logement/show.html.twig', [
            'logement' => $logement,
            'current_menu' => 'Logements'
        ]);
    }
}
