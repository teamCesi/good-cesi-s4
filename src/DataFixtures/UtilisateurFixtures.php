<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Utilisateur;

class UtilisateurFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 5; $i++){
            $user = new Utilisateur();
            $user->setNom("Nom $i")
                 ->setPrenom("Prénom $i")
                 ->setEmail("email-$i@gmail.com")
                 ->setPassword("password")
                 ->setAdresse("Adresse $i")
                 ->setUsername("Username $i")
                 ->setIsAdmin(false);
        
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
