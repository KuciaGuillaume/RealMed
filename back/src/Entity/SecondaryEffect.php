<?php

namespace App\Entity;

use App\Repository\SecondaryEffectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SecondaryEffectRepository::class)
 */
class SecondaryEffect
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $severity;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $severityScore;

    /**
     * @ORM\ManyToMany(targetEntity=Molecule::class, inversedBy="secondaryEffects")
     */
    private $Molecule;

    public function __construct()
    {
        $this->Molecule = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSeverity(): ?string
    {
        return $this->severity;
    }

    public function setSeverity(?string $severity): self
    {
        $this->severity = $severity;

        return $this;
    }

    public function getSeverityScore(): ?int
    {
        return $this->severityScore;
    }

    public function setSeverityScore(?int $severityScore): self
    {
        $this->severityScore = $severityScore;

        return $this;
    }

    /**
     * @return Collection<int, Molecule>
     */
    public function getMolecule(): Collection
    {
        return $this->Molecule;
    }

    public function addMolecule(Molecule $molecule): self
    {
        if (!$this->Molecule->contains($molecule)) {
            $this->Molecule[] = $molecule;
        }

        return $this;
    }

    public function removeMolecule(Molecule $molecule): self
    {
        $this->Molecule->removeElement($molecule);

        return $this;
    }
}
