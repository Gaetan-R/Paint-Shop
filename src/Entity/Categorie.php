<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorieRepository::class)
 */
class Categorie
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
     * @ORM\Column(type="text")
     */
    private $Description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\ManyToMany(targetEntity=Peinture::class, mappedBy="categorie")
     */
    private $peintures;

    public function __construct()
    {
        $this->peintures = new ArrayCollection();
    }



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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(string $Description): self
    {
        $this->Description = $Description;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection|Peinture[]
     */
    public function getPeintures(): Collection
    {
        return $this->peintures;
    }

    public function addPeinture(Peinture $peinture): self
    {
        if (!$this->peintures->contains($peinture)) {
            $this->peintures[] = $peinture;
            $peinture->addCategorie($this);
        }

        return $this;
    }

    public function removePeinture(Peinture $peinture): self
    {
        if ($this->peintures->removeElement($peinture)) {
            $peinture->removeCategorie($this);
        }

        return $this;
    }


}
