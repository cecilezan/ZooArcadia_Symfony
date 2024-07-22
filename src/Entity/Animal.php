<?php

namespace App\Entity;

use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue (strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $birthDate = null;

    #[ORM\Column(length: 64)]
    private ?string $etat = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?race $race_id = null;

    #[ORM\ManyToOne(inversedBy: 'animals')]
    #[ORM\JoinColumn(nullable: false)]
    private ?habitat $habitat_id = null;

    /**
     * @var Collection<int, VetReport>
     */
    #[ORM\OneToMany(targetEntity: VetReport::class, mappedBy: 'animal_id', orphanRemoval: true)]
    private Collection $vetReports;

    public function __construct()
    {
        $this->vetReports = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): static
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getEtat(): ?string
    {
        return $this->etat;
    }

    public function setEtat(string $etat): static
    {
        $this->etat = $etat;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(?\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getRaceId(): ?race
    {
        return $this->race_id;
    }

    public function setRaceId(?race $race_id): static
    {
        $this->race_id = $race_id;

        return $this;
    }

    public function getHabitatId(): ?habitat
    {
        return $this->habitat_id;
    }

    public function setHabitatId(?habitat $habitat_id): static
    {
        $this->habitat_id = $habitat_id;

        return $this;
    }

    /**
     * @return Collection<int, VetReport>
     */
    public function getVetReports(): Collection
    {
        return $this->vetReports;
    }

    public function addVetReport(VetReport $vetReport): static
    {
        if (!$this->vetReports->contains($vetReport)) {
            $this->vetReports->add($vetReport);
            $vetReport->setAnimalId($this);
        }

        return $this;
    }

    public function removeVetReport(VetReport $vetReport): static
    {
        if ($this->vetReports->removeElement($vetReport)) {
            // set the owning side to null (unless already changed)
            if ($vetReport->getAnimalId() === $this) {
                $vetReport->setAnimalId(null);
            }
        }

        return $this;
    }
}
