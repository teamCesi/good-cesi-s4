<?php

namespace App\Form;

use App\Entity\Article;
use App\Entity\Categorie;
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
            ->add('prix', null, array('label' => 'Prix (€)'))
            ->add('description')
            ->add('image')
            ->add('poids', null, array('label' => 'Poids (Kg)'))
            ->add('fraisDePort', null, array('label' => 'Frais de port (€)'))
            ->add('categories', EntityType::class, array(
                'class' => Categorie::class,
                'multiple' => true,
                'expanded' => true,
                'choice_label' => 'nom')); 
            
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Article::class,
        ]);
    }
}
