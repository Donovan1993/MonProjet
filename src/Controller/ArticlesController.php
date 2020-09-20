<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Articles;
use App\Entity\Users;
use App\Entity\Commentaires;
use App\Form\AjoutArticleType;
use App\Form\CommentairesType;
use App\Repository\ArticlesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request; // Nous avons besoin d'accéder à la requête pour obtenir le numéro de page
use Knp\Component\Pager\PaginatorInterface; // Nous appelons le bundle KNP Paginator
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Contracts\Translation\TranslatorInterface;
use FOS\CKEditorBundle\Form\Type\FOSCKEditorType;


/**
 * Class ArticlesController
 * @package App\Controller
 * @Route("/newsletter", name="actualites_")
 */
class ArticlesController extends AbstractController
{
    /**
     * @var ArticlesRepository
     */
    private $repository;
    /**
     * @var ObjectManager
     */
    private $em;

    public function __construct(ArticlesRepository $repository, EntityManagerInterface $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/", name="articles")
     */
    public function index(Request $request, PaginatorInterface $paginator) // Nous ajoutons les paramètres requis
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $donnees = $this->getDoctrine()->getRepository(Articles::class)->findAll();

        $articles = $paginator->paginate(

            $donnees, // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,

        ]);
    }

    /**
     * @Route("/{slug}", name="article")
     */
    public function article($slug, Request $request)
    {
        // On récupère l'article correspondant au slug
        $article = $this->getDoctrine()->getRepository(Articles::class)->findOneBy(['slug' => $slug]);
        $commentaires = $this->getDoctrine()->getRepository(Commentaires::class)->findBy([
            'articles' => $article,
            'actif' => 1
        ]);
        if (!$article) {
            // Si aucun article n'est trouvé, nous créons une exception
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        // Nous créons l'instance de "Commentaires"
        $commentaire = new Commentaires();

        // Nous créons le formulaire en utilisant "CommentairesType" et on lui passe l'instance
        $form = $this->createForm(CommentairesType::class, $commentaire);

        // Nous récupérons les données
        $form->handleRequest($request);

        // Nous vérifions si le formulaire a été soumis et si les données sont valides
        if ($form->isSubmitted() && $form->isValid()) {
            echo "<h2> Votre commentaire a été transmis, il sera visible aprés validation 💌!</h2>";
            // Hydrate notre commentaire avec l'article
            $commentaire->setArticles($article);

            // Hydrate notre commentaire avec la date et l'heure courants
            $commentaire->setCreatedAt(new \DateTime('now'));

            $doctrine = $this->getDoctrine()->getManager();

            // On hydrate notre instance $commentaire
            $doctrine->persist($commentaire);

            // On écrit en base de données
            $doctrine->flush();
        }
        // Si l'article existe nous envoyons les données à la vue
        return $this->render('articles/article.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'commentaires' => $commentaires,
        ]);
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/article/ajouter", name="ajout_article")
     */
    public function ajout(Request $request, TranslatorInterface $translator)
    {

        //var_dump($this->getUser());
        //die();
        $article = new Articles();

        $form = $this->createForm(AjoutArticleType::class, $article);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $article->setUsers($this->getUser());


            $image = $form->get('featured_image')->getData();
            if ($image) {
                $fichier = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    //$this->getParameter('app.path.featured_images'),
                    $fichier
                );
                $article->setFeaturedImage($fichier);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($article);
            $entityManager->flush();

            $message = $translator->trans('Article published successfully');

            $this->addFlash('message', $message);
            return $this->redirectToRoute('actualites_articles');
        }



        return $this->render('articles/ajout.html.twig', [
            'articleForm' => $form->createView(),
        ]);
    }
}
