<?php

namespace App\Controller;

use App\Repository\UtilisateurRepository;
use App\Entity\Utilisateur;
use App\Form\UtilisateurType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class UtilisateurController extends Controller
{
    /**
     * @Route("/utilisateur", name="utilisateur_list")
     */
    public function indexAction(UtilisateurRepository $repo)
    {

        $utilisateurs = $repo->findAll();

        dump($utilisateurs);

        return $this->render('utilisateur/index.html.twig', [
            'controller_name' => 'UtilisateurController', 
            'utilisateurs' => $utilisateurs
        ]);
    }

    /**
     * @Route("/utilisateur/new", name="utilisateur_new")
     */
    public function createAction(Request $request, ObjectManager $manager) {
        
        // créer un utilisateur
        $utilisateur = new utilisateur();

        // besoin du formulaire UtilisateurType
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        // On doit analyser la requête HTTP
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // itégrer utilisateur à la bdd avec manager
            $utilisateur->setIsAdmin(0);
            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('utilisateur_list');
        }

        $formView = $form->createView();
        // Aficher la vue
        return $this->render('utilisateur/create.html.twig', [
            'form' => $formView
        ]);
    }

    /**
     * @Route("/utilisateur/{id}/edit", name="utilisateur_edit")
     */
    public function editAction(Utilisateur $utilisateur, ObjectManager $manager, Request $request){
        $form = $this->createForm(UtilisateurType::class, $utilisateur);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($utilisateur);
            $manager->flush();

            return $this->redirectToRoute('utilisateur_show', [
                'id' => $utilisateur->getId()
            ]);
        }

        $formView = $form->createView();

        return $this->render("utilisateur/edit.html.twig", [
            'form' => $formView
        ]);
    }

    /**
     * @Route("/utilisateur/{id}", name="utilisateur_show")
     */
    public function showAction(Utilisateur $utilisateur){
        return $this->render('utilisateur/show.html.twig', [
            'utilisateur' => $utilisateur
        ]);
    }

    /**
     * @Route("utilisateur/{id}/delete", name="utilisateur_delete")
     */
    public function deleteAction(Utilisateur $utilisateur, ObjectManager $manager) {
        
        $manager->remove($utilisateur);
        $manager->flush();

        return $this->redirectToRoute('utilisateur_list');
    }
}
