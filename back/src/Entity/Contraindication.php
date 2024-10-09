<?php

namespace App\Entity;

use App\Repository\ContraindicationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContraindicationRepository::class)
 */
class Contraindication
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, inversedBy="contraindications")
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=Medicine::class, mappedBy="contraindication")
     */
    private $medicines;

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->medicines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return Collection<int, Medicine>
     */
    public function getMedicines(): Collection
    {
        return $this->medicines;
    }

    public function addMedicine(Medicine $medicine): self
    {
        if (!$this->medicines->contains($medicine)) {
            $this->medicines[] = $medicine;
            $medicine->addContraindication($this);
        }

        return $this;
    }

    public function removeMedicine(Medicine $medicine): self
    {
        if ($this->medicines->removeElement($medicine)) {
            $medicine->removeContraindication($this);
        }

        return $this;
    }
}
