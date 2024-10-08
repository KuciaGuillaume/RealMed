<?php

namespace App\Entity;

use App\Repository\MoleculeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MoleculeRepository::class)
 */
class Molecule
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Medicine::class, mappedBy="molecule")
     */
    private $Medicine;

    public function __construct()
    {
        $this->Medicine = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return Collection<int, Medicine>
     */
    public function getMedicine(): Collection
    {
        return $this->Medicine;
    }

    public function addMedicine(Medicine $medicine): self
    {
        if (!$this->Medicine->contains($medicine)) {
            $this->Medicine[] = $medicine;
            $medicine->setMolecule($this);
        }

        return $this;
    }

    public function removeMedicine(Medicine $medicine): self
    {
        if ($this->Medicine->removeElement($medicine)) {
            // set the owning side to null (unless already changed)
            if ($medicine->getMolecule() === $this) {
                $medicine->setMolecule(null);
            }
        }

        return $this;
    }
}
