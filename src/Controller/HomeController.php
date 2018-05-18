<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Article;
use App\Repository\ArticleRepository;




class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function indexAction(ArticleRepository $repo)
    {

        $articles = $repo->findAll();

        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'articles' => $articles
        ]);
    }


}
