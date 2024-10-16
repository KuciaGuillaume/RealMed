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
 * @ORM\Table(name="`user`")
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
    private $username;

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
     * @ORM\ManyToMany(targetEntity=Contraindication::class, mappedBy="users")
     */
    private $contraindications;

    /**
     * @ORM\ManyToMany(targetEntity=Medicine::class, inversedBy="users")
     */
    private Collection $favs;

    public function __construct()
    {
        $this->contraindications = new ArrayCollection();
        $this->favs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
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

    /**
     * @return Collection<int, Contraindication>
     */
    public function getContraindications(): Collection
    {
        return $this->contraindications;
    }

    public function addContraindication(Contraindication $contraindication): self
    {
        if (!$this->contraindications->contains($contraindication)) {
            $this->contraindications[] = $contraindication;
            $contraindication->addUser($this);
        }

        return $this;
    }

    public function removeContraindication(Contraindication $contraindication): self
    {
        if ($this->contraindications->removeElement($contraindication)) {
            $contraindication->removeUser($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Medicine>
     */
    public function getFavs(): Collection
    {
        return $this->favs;
    }

    public function addFav(Medicine $fav): self
    {
        if (!$this->favs->contains($fav)) {
            $this->favs[] = $fav;
        }

        return $this;
    }

    public function removeFav(Medicine $fav): self
    {
        $this->favs->removeElement($fav);

        return $this;
    }

    public function isFavs(Medicine $medicine): bool
    {
        foreach ($this->favs as $fav) {
            if ($fav->getId() === $medicine->getId()) {
                return true;
            }
        }
        return false;
    }
}
