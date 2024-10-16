<?php

namespace App\Entity;

use App\Repository\MedicineRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="favs")
     */
    private $users;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $color;

    /**
     * @ORM\ManyToMany(targetEntity=Contraindication::class, inversedBy="medicines")
     */
    private $contraindication;

    /**
     * @ORM\ManyToMany(targetEntity=Medicine::class, inversedBy="users")
    */
    private Collection $favs;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $efficiencyTime;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $aspect;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $size;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $conditioning;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondaryEffects;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $format;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $administration;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $durationTime;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $specificConditions = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="json", nullable=true)
     */
    private $secondaryEffectsDetailed = [];

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $imageLink;

    /**
     * @return array|null
     */
    public function getSecondaryEffectsDetailed(): ?array
    {
        return $this->secondaryEffectsDetailed;
    }

    /**
     * @param array|null $secondaryEffectsDetailed
     * @return self
     */
    public function setSecondaryEffectsDetailed(?array $secondaryEffectsDetailed): self
    {
        $this->secondaryEffectsDetailed = $secondaryEffectsDetailed;

        return $this;
    }

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $shortDescription;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $usageInstructions;

    /**
     * @return string|null
     */
    public function getShortDescription(): ?string
    {
        return $this->shortDescription;
    }

    /**
     * @param string|null $shortDescription
     * @return self
     */
    public function setShortDescription(?string $shortDescription): self
    {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUsageInstructions(): ?string
    {
        return $this->usageInstructions;
    }

    /**
     * @param string|null $usageInstructions
     * @return self
     */
    public function setUsageInstructions(?string $usageInstructions): self
    {
        $this->usageInstructions = $usageInstructions;

        return $this;
    }

    public function getImageLink(): ?string
    {
        return $this->imageLink;
    }

    public function setImageLink(?string $imageLink): self
    {
        $this->imageLink = $imageLink;

        return $this;
    }

    public function __construct()
    {
        $this->users = new ArrayCollection();
        $this->contraindication = new ArrayCollection();
    }

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

    public function isFavs(Medicine $medicine): bool
    {
        return $this->favs->contains($medicine);
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
            $user->addFav($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeFav($this);
        }

        return $this;
    }

    public function getColor(): ?string
    {
        return $this->color;
    }

    public function setColor(?string $color): self
    {
        $this->color = $color;

        return $this;
    }

    /**
     * @return Collection<int, Contraindication>
     */
    public function getContraindication(): Collection
    {
        return $this->contraindication;
    }

    public function addContraindication(Contraindication $contraindication): self
    {
        if (!$this->contraindication->contains($contraindication)) {
            $this->contraindication[] = $contraindication;
        }

        return $this;
    }

    public function removeContraindication(Contraindication $contraindication): self
    {
        $this->contraindication->removeElement($contraindication);

        return $this;
    }

    public function getEfficiencyTime(): ?string
    {
        return $this->efficiencyTime;
    }

    public function setEfficiencyTime(?string $efficiencyTime): self
    {
        $this->efficiencyTime = $efficiencyTime;

        return $this;
    }

    public function getAspect(): ?string
    {
        return $this->aspect;
    }

    public function setAspect(?string $aspect): self
    {
        $this->aspect = $aspect;

        return $this;
    }

    public function getSize(): ?string
    {
        return $this->size;
    }

    public function setSize(?string $size): self
    {
        $this->size = $size;

        return $this;
    }

    public function getConditioning(): ?array
    {
        return $this->conditioning;
    }

    public function setConditioning(?array $conditioning): self
    {
        $this->conditioning = $conditioning;

        return $this;
    }

    public function getSecondaryEffects(): ?string
    {
        return $this->secondaryEffects;
    }

    public function setSecondaryEffects(?string $secondaryEffects): self
    {
        $this->secondaryEffects = $secondaryEffects;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(?string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getAdministration(): ?string
    {
        return $this->administration;
    }

    public function setAdministration(?string $administration): self
    {
        $this->administration = $administration;

        return $this;
    }

    public function getDurationTime(): ?string
    {
        return $this->durationTime;
    }

    public function setDurationTime(?string $durationTime): self
    {
        $this->durationTime = $durationTime;

        return $this;
    }

    public function getSpecificConditions(): ?array
    {
        return $this->specificConditions;
    }

    public function setSpecificConditions(?array $specificConditions): self
    {
        $this->specificConditions = $specificConditions;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function __toString(): string
    {
        return $this->name;
    }
}
