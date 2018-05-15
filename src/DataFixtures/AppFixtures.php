<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;
use App\Entity\Article;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // 1. Créer les utilisateurs
        for($i = 1; $i <= 5; $i++){
            $user = new Utilisateur();
            $user->setNom("Nom $i")
                 ->setPrenom("Prénom $i")
                 ->setEmail("email-$i@gmail.com")
                 ->setPassword("password")
                 ->setAdresse("Adresse $i")
                 ->setUsername("Username $i")
                 ->setIsAdmin(false);
                 
            for($j = 0; $j < mt_rand(0, 5); $j++) {
                $article = new Article();
                $article->setNom("Article $j")
                        ->setDescription("Description de l'article $j")
                        ->setPrix(mt_rand(10, 200))
                        ->setPoids(mt_rand(0, 20))
                        ->setImage("http://lorempicsum.com/futurama/350/200/1")
                        ->setFraisDePort(mt_rand(2, 25))
                        ->setDateCreation(new \DateTime())
                        ->setUtilisateur($user);
                
                $manager->persist($article);
            }
        
            $manager->persist($user);
        }
        
        $admin = new Utilisateur();
        $admin->setNom("Chamla")
              ->setPrenom("Lior")
              ->setEmail("lchamla@gmail.com")
              ->setPassword("admin")
              ->setUsername("admin")
              ->setAdresse("Adresse à la con")
              ->setIsAdmin(true);
              
        $manager->persist($admin);

        $manager->flush();
    }
}
