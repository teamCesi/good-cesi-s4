<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Article;

class ArticleFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for($i = 1; $i <= 50; $i++) {
            $article = new Article();
            $article->setNom("Article $i")
                    ->setDescription("Description de l'article $i")
                    ->setPrix(mt_rand(10, 200))
                    ->setPoid(mt_rand(0, 20))
                    ->setImage("http://lorempicsum.com/futurama/350/200/1")
                    ->setFraisDePort(mt_rand(2, 25))
                    ->setDateCreation(new \DateTime());
            
            $manager->persist($article);
        }
        // $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
