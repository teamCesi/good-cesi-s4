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
        // regarde la request : récupère la valeur du button radio expedie
        $statut = $request->request->get("expedie");
        // si statut a la valeur expedie 
        if($statut == "expedie") {
            // alors on passe le statut à true pour envoyer en bdd
            $statut = true;
        } else {
            // sinon on passe le statut à false
            $statut = false;
        }

        $commande->setIsEnvoyer($statut);

        $manager->persist($commande);

        $manager->flush();

        return $this->redirectToRoute('commande_list');
    }

    /**
     * @Route("/commande/utilisateur", name="commande_user")
     */
    public function commandesUserAction() {

        $utilisateur = $this->getUser();
        
        // SELECT * FROM commande WHERE utilisateur_id
        $commandes = $this->getDoctrine()
            ->getRepository(Commande::class)
            ->findByUtilisateur($utilisateur);

        return $this->render('commande/commandes.html.twig',[
            'commandes' => $commandes
        ]);

    }
}
