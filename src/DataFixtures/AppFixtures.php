<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\Article;
use App\Entity\Commande;
use App\Entity\Categorie;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    private $encoder;
    
    public function __construct(UserPasswordEncoderInterface $encoder){
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        // 1. Créer les utilisateurs
         for($i = 1; $i <= 5; $i++){
            $user = new Utilisateur();
            
            // On demande à encoder un password
            $password = $this->encoder->encodePassword($user, "password");
            
            $user->setNom("Nom $i")
                 ->setPrenom("Prénom $i")
                 ->setEmail("email-$i@gmail.com")
                 ->setPassword($password)
                 ->setAdresse("Adresse $i")
                 ->setUsername("Username $i")
                 ->setIsAdmin(false);

                 $manager->persist($user);
                 
           // for($j = 0; $j < mt_rand(0, 5); $j++) {
                $article = new Article();
                $article->setNom("Article $i")
                        ->setDescription("Description de l'article $i")
                        ->setPrix(mt_rand(10, 200))
                        ->setPoids(mt_rand(0, 20))
                        ->setImage("http://lorempicsum.com/futurama/350/200/1")
                        ->setFraisDePort(mt_rand(2, 25))
                        ->setDateCreation(new \DateTime())
                        ->setIsVendu(false)
                        ->setUtilisateur($user);
                
                    $manager->persist($article);
          //  }

             //   for($k = 0; $k < mt_rand(0,5); $k++ ){
                    $commande = new Commande();
                    $commande->setUtilisateur($user)
                            ->setArticle($article);
  
                    $manager->persist($commande);
             //   }

                    $categorie = new Categorie();
                    $categorie->setNom("catergorie $i")
                                ->addArticle($article);
                    $manager->persist($categorie);
                                
           
      //  }
    }
        $admin = new Utilisateur();
        
        $password = $this->encoder->encodePassword($admin, "admin");
        
        $admin->setNom("Admin")
              ->setPrenom("Admin")
              ->setEmail("admin@gmail.com")
              ->setPassword($password)
              ->setUsername("admin")
              ->setAdresse("adresse")
              ->setIsAdmin(true);
              
        $manager->persist($admin);

        $manager->flush();
             
    }
}
