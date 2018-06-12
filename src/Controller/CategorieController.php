<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Categorie;
use App\Form\CategorieType;
use App\Repository\CategorieRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CategorieController extends Controller
{
    /**
     * @Route("/categorie", name="categorie_list")
     * @IsGranted("ROLE_ADMIN")
     */
    public function indexAction(CategorieRepository $repo)
    {
    	$categories = $repo->findAll();
    	
        return $this->render('categorie/index.html.twig', [
            'controller_name' => 'CategorieController', 'categories' => $categories
        ]);
    }

    /**
     * @Route("/categorie/new", name="categorie_new")
     * @IsGranted("ROLE_ADMIN")
     */
    public function createAction(Request $request, ObjectManager $manager) {
    	
    	$categorie = new categorie();

    	$form = $this->createForm(CategorieType::class, $categorie);

    	$form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $manager->persist($categorie);

            $manager->flush();

            return $this->redirectToRoute('categorie_list');
        }

        $formView = $form->createView();

        return $this->render('categorie/create.html.twig', [
           'form' => $formView
        ]);

    }

    /**
     * @Route("/categorie/{id}/edit", name="categorie_edit")
     * @IsGranted("ROLE_ADMIN")
     */
    public function editAction(Categorie $categorie, ObjectManager $manager, Request $request) {

        $form = $this->createForm(CategorieType::class, $categorie);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($categorie);
            $manager->flush();
            return $this->redirectToRoute('categorie_list', [
                'id' => $categorie->getId()
            ]);
        }

        $formView = $form->createView();

        return $this->render('categorie/edit.html.twig', [
            'form' => $formView
        ]);
    }

}
