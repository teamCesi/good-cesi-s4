<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Doctrine\Common\Persistence\ObjectManager;

use App\Entity\Commande;
use App\Repository\CommandeRepository;
use Symfony\Component\HttpFoundation\Request;

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

     /**
     * @Route("/commande/{id}/expedier", name="commande_expedier")
     */
    public function expedierAction(Request $request, Commande $commande, ObjectManager $manager) {
        $statut = $request->request->get("expedie");
        if($statut == "expedie") {
            $statut = true;
        } else {
            $statut = false;
        }

        $commande->setIsEnvoyer($statut);

        $manager->persist($commande);

        $manager->flush();

        return $this->redirectToRoute('commande_list');
    }
}
