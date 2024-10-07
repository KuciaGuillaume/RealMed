<?php

namespace App\Entity;

use App\Repository\MedicineRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MedicineRepository::class)
 */
class Medicine
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
    private $dosage;

    /**
     * @ORM\ManyToOne(targetEntity=Molecule::class, inversedBy="Medicine")
     */
    private $molecule;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDosage(): ?string
    {
        return $this->dosage;
    }

    public function setDosage(string $dosage): self
    {
        $this->dosage = $dosage;

        return $this;
    }

    public function getMolecule(): ?Molecule
    {
        return $this->molecule;
    }

    public function setMolecule(?Molecule $molecule): self
    {
        $this->molecule = $molecule;

        return $this;
    }
}
