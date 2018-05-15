<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;


class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom')
            ->add('prix')
            ->add('description')
            ->add('image')
            ->add('poids')
            ->add('fraisDePort')
            // ->add('utilisateur', EntityType::class, [
            //     'class' => Utilisateur::class,
            //     // 'choice_label' => 'nom'
            //     'choice_label' => function($utilisateur) {
            //         return $utilisateur->getPrenom() . ' ' . $utilisateur->getNom();
            //     }
            // ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
