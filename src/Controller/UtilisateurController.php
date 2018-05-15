<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
}
