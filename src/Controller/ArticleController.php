<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;
use App\Repository\ArticleRepository;
use App\Form\ArticleType;

class ArticleController extends Controller
{
    /**
     * @Route("/", name="article_list")
     */
    public function indexAction(ArticleRepository $repo)
    {
        // 1. Je récupère le repository en question
        // $repo = $this->getDoctrine()->getRepository(Article::class);
        
        // 2. Je requête ce dont j'ai besoin (ici, tous les articles)
        $articles = $repo->findAll();
        
        // 3. On débug avec dump()
        dump($articles);
        
        return $this->render('article/index.html.twig', [
            'controller_name' => 'ArticleController',
            'articles' => $articles
        ]);
    }
    
    /**
     * @Route("/article/new", name="article_new")
     */
    public function createAction() {
        // 1. Créer un article
        $article = new Article();
        
        $article->setNom("Bonjour")
                ->setPrix(200)
                ->setDescription("Kikoo les amis !");
        
        // 2. J'ai besoin du formulaire ArticleType
        $form = $this->createForm(ArticleType::class, $article);
        
        $formView = $form->createView();
        // Affichage du formulaire
        return $this->render('article/create.html.twig', [
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
    
    
}
