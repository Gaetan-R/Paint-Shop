<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $telephone;

    /**
     * @ORM\Column(type="text")
     */
    private $aPropos;

    /**
     * @ORM\OneToMany(targetEntity=Peinture::class, mappedBy="user", orphanRemoval=true)
     */
    private $peintures;

    /**
     * @ORM\OneToMany(targetEntity=Blogpost::class, mappedBy="user", orphanRemoval=true)
     */
    private $blogposts;

    /**
     * @ORM\OneToMany(targetEntity=Categorie::class, mappedBy="user")
     */
    private $categories;

    /**
     * @ORM\ManyToMany(targetEntity=Commentaire::class, mappedBy="user")
     */
    private $commentaires;

    public function __construct()
    {
        $this->peintures = new ArrayCollection();
        $this->blogposts = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->commentaires = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getAPropos(): ?string
    {
        return $this->aPropos;
    }

    public function setAPropos(string $aPropos): self
    {
        $this->aPropos = $aPropos;

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
            $peinture->setUser($this);
        }

        return $this;
    }

    public function removePeinture(Peinture $peinture): self
    {
        if ($this->peintures->removeElement($peinture)) {
            // set the owning side to null (unless already changed)
            if ($peinture->getUser() === $this) {
                $peinture->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Blogpost[]
     */
    public function getBlogposts(): Collection
    {
        return $this->blogposts;
    }

    public function addBlogpost(Blogpost $blogpost): self
    {
        if (!$this->blogposts->contains($blogpost)) {
            $this->blogposts[] = $blogpost;
            $blogpost->setUser($this);
        }

        return $this;
    }

    public function removeBlogpost(Blogpost $blogpost): self
    {
        if ($this->blogposts->removeElement($blogpost)) {
            // set the owning side to null (unless already changed)
            if ($blogpost->getUser() === $this) {
                $blogpost->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Categorie[]
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Categorie $category): self
    {
        if (!$this->categories->contains($category)) {
            $this->categories[] = $category;
            $category->setUser($this);
        }

        return $this;
    }

    public function removeCategory(Categorie $category): self
    {
        if ($this->categories->removeElement($category)) {
            // set the owning side to null (unless already changed)
            if ($category->getUser() === $this) {
                $category->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Commentaire[]
     */
    public function getCommentaires(): Collection
    {
        return $this->commentaires;
    }

    public function addCommentaire(Commentaire $commentaire): self
    {
        if (!$this->commentaires->contains($commentaire)) {
            $this->commentaires[] = $commentaire;
            $commentaire->addUser($this);
        }

        return $this;
    }

    public function removeCommentaire(Commentaire $commentaire): self
    {
        if ($this->commentaires->removeElement($commentaire)) {
            $commentaire->removeUser($this);
        }

        return $this;
    }

    public function __toString()
    {
        return $this->nom;
    }
}
