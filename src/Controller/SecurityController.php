<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Form\LoginType;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="login")
     */
    public function loginAction()
    {
        // $form = $this->createForm(LoginType::class);
        
        // $formView = $form->createView();
           
        return $this->render('security/index.html.twig', [
            'controller_name' => 'SecurityController',
            // 'form' => $formView
        ]);
    }
    
    /**
     * @Route("/logout", name="logout")
     */
    public function logoutAction() {
        
    }
}
