<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use App\Entity\Commande;
use App\Repository\CommandeRepository;

class CommandeController extends Controller
{
    /**
     * @Route("/commande", name="commande_list")
     */
    public function indexAction(CommandeRepository $repo)
    {

        // Je récupère toutes les commandes 
        $commandes = $repo->findAll();

        return $this->render('commande/index.html.twig', [
            'controller_name' => 'CommandeController',
            'commandes' => $commandes
        ]);
    }
}
