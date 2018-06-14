<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Article;
use App\Entity\Commande;
use App\Form\ArticleType;
use App\Form\AcheterType;
use App\Entity\Utilisateur;
use App\Repository\ArticleRepository;
use App\Repository\UtilisateurRepository;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class ArticleController extends Controller
{
   
    /**
     * @Route("/article", name="article_list")
     */
    public function indexAction(ArticleRepository $repo)
    {
        // 1. Je récupère le repository en question
        // $repo = $this->getDoctrine()->getRepository(Article::class);

        // 2. Je requête ce dont j'ai besoin (ici, tous les articles)
        $articles = $repo->findAll();

        // 3. On débug avec dump()
        //dump($articles);

        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }

    /**
     * @Route("/article/vente", name="article_vente")
     * @IsGranted("ROLE_USER")
     */
    public function createAction(Request $request, ObjectManager $manager) {
        // 1. Créer un article
        $article = new Article();

        // $article->setNom("Bonjour")
        //         ->setPrix(200)
        //         ->setDescription("Kikoo les amis !");

        // 2. J'ai besoin du formulaire ArticleType
        $form = $this->createForm(ArticleType::class, $article);

        // 3. On doit analyser la requete HTTP
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
        	dump($article);
            // 4. Intégrer l'article à la base avec le manager
            $article->setDateCreation(new \DateTime());
            $user = $this->getUser();

            $article->setUtilisateur($user)
            		->setIsVendu(false);;
            // 5. On fait un foreach pour la relation avec la table article_categorie
            foreach($article->getCategories() as $category){
            	
            	$category->addArticle($article);
            	$manager->persist($category);   
            }


            $manager->persist($article);
            $manager->flush();

            return $this->redirectToRoute('article_list');
        }

        $formView = $form->createView();
        // Affichage du formulaire
        return $this->render('article/create.html.twig', [
           'form' => $formView
        ]);
    }

    /**
     * @Route("/article/{id}/edit", name="article_edit")
     * @IsGranted("ROLE_USER")
     */
    public function editAction(Article $article, ObjectManager $manager, Request $request) {

        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($article);
            $manager->flush();
            return $this->redirectToRoute('article_show', [
                'id' => $article->getId()
            ]);
        }

        $formView = $form->createView();

        return $this->render('article/edit.html.twig', [
            'form' => $formView
        ]);
    }

    /**
     * @Route("/article/{id}", name="article_show")
     */
    public function showAction(Article $article, $id) {
        // 1. J'ai besoin du repository des articles
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        // 2. Je veux choper l'article en question
        // $article = $repo->find($id);
        // 3. Afficher
        return $this->render('article/show.html.twig', [
           'article' => $article
        ]);
    }

    /**
     * @Route("/article/{id}/delete", name="article_delete")
     * @IsGranted("ROLE_USER")
     */
    public function deleteAction(Article $article, ObjectManager $manager) {
        // 1. J'ai besoin du manager
        // $manager = $this->getDoctrine()->getManager();

        // 2. Supprimer l'article
        $manager->remove($article);
        $manager->flush();

        // 3. Je redirige vers la liste !
        return $this->redirectToRoute('article_list');
    }

    /**
     * @Route("/article/{id}/acheter", name="article_acheter")
     * @IsGranted("ROLE_USER")
    */

    public function acheterAction(Article $article, ObjectManager $manager, Request $request) {

        // récupère l'utilisateur
        $utilisateur = $this->getUser();
        
        // 1. Modif adresse client en bas

        $form = $this->createForm(AcheterType::class);

        $form->handleRequest($request);

        // 2. test champ 10 chiffres && 
        if($form->isSubmitted() && $form->isValid()){
      
            $cb = $_POST['cb'];

            // calcul la longueur
            $longeur = strlen($cb);
            // s'il n'est pas vide / si c'est un nombre entier / possède 10 chiffres
            if(!empty($cb) && ctype_digit($cb) && $longeur == 10) {
                // récupère adresse utilisateur
                $commande = new Commande();
                $commande->setUtilisateur($utilisateur)
                         ->setArticle($article)
                         ->setDateValidation(new \DateTime())
                         ->setIsEnvoyer(false);
                         
                //$manager->persist($utilisateur);
                $manager->persist($commande);
                
                // 3. Supprimer l'article acheté
                //$manager->remove($article);
                // 3. Modifier le bolean isVendu à true
                $article->setIsVendu(true);
                $manager->persist($article);

                // envoie dans la base : adresse utilisateur + delete article
                $manager->flush();

                // redirige vers la vue article_list
                return $this->redirectToRoute('article_list');

            } else {
                // message flash
                $this->addFlash(
                    'chiffres',
                    'Veuillez indiquez 10 chiffres'
                );
            }
      
        }

        $formView = $form->createView();
        
        return $this->render('article/acheter.html.twig', [
            'form' => $formView
        ]);
    }
}
