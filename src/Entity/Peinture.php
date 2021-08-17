<?php

namespace App\Entity;

use App\Repository\PeintureRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PeintureRepository::class)
 */
class Peinture
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nom;

    /**
     * @ORM\Column(type="integer")
     */
    private $Largeur;

    /**
     * @ORM\Column(type="integer")
     */
    private $Hauteur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $Vente;

    /**
     * @ORM\Column(type="datetime")
     */
    private $DateRealisation;

    /**
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="integer")
     */
    private $Prix;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="peintures")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Categorie::class, inversedBy="peintures")
     */
    private $categorie;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getLargeur(): ?int
    {
        return $this->Largeur;
    }

    public function setLargeur(int $Largeur): self
    {
        $this->Largeur = $Largeur;

        return $this;
    }

    public function getHauteur(): ?int
    {
        return $this->Hauteur;
    }

    public function setHauteur(int $Hauteur): self
    {
        $this->Hauteur = $Hauteur;

        return $this;
    }

    public function getVente(): ?bool
    {
        return $this->Vente;
    }

    public function setVente(bool $Vente): self
    {
        $this->Vente = $Vente;

        return $this;
    }

    public function getDateRealisation(): ?\DateTimeInterface
    {
        return $this->DateRealisation;
    }

    public function setDateRealisation(\DateTimeInterface $DateRealisation): self
    {
        $this->DateRealisation = $DateRealisation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getPrix(): ?int
    {
        return $this->Prix;
    }

    public function setPrix(int $Prix): self
    {
        $this->Prix = $Prix;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
