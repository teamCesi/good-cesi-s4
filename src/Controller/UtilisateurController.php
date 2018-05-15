<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Utilisateur;

class UtilisateurController extends Controller
{
    /**
     * @Route("/utilisateur", name="utilisateur")
     */
    public function index()
    {
        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController',
        ]);
    }
    
    /**
     * @Route("/utilisateurs/{id}", name="utilisateur_show")
     */
    public function showAction(Utilisateur $user) {
        
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $user
        ]);
    }
    
}
