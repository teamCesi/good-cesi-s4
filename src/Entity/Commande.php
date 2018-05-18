<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $dateExp;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isEnvoyer;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Article", inversedBy="commande")
     * @ORM\JoinColumn(nullable=true)
     */
    private $article;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Utilisateur", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=true)
     */
    private $utilisateur;

    // 

    public function getId()
    {
        return $this->id;
    }

    public function getDateExp(): ?\DateTimeInterface
    {
        return $this->dateExp;
    }

    public function setDateExp(\DateTimeInterface $dateExp): self
    {
        $this->dateExp = $dateExp;

        return $this;
    }

    public function getIsEnvoyer(): ?bool
    {
        return $this->isEnvoyer;
    }

    public function setIsEnvoyer(bool $isEnvoyer): self
    {
        $this->isEnvoyer = $isEnvoyer;

        return $this;
    }

    public function getArticle(): ?Article
    {
        return $this->article;
    }

    public function setArticle(Article $article): self
    {
        $this->article = $article;

        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): self
    {
        $this->utilisateur = $utilisateur;

        return $this;
    }
}
