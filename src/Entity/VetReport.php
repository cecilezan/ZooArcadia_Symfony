<?php

namespace App\Entity;

use App\Repository\VetReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VetReportRepository::class)]
class VetReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue (strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $nameVeto = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateVisit = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $detail = null;

    #[ORM\ManyToOne(inversedBy: 'vetReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Animal $animal_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameVeto(): ?string
    {
        return $this->nameVeto;
    }

    public function setNameVeto(string $nameVeto): static
    {
        $this->nameVeto = $nameVeto;

        return $this;
    }

    public function getDateVisit(): ?\DateTimeInterface
    {
        return $this->dateVisit;
    }

    public function setDateVisit(\DateTimeInterface $dateVisit): static
    {
        $this->dateVisit = $dateVisit;

        return $this;
    }

    public function getDetail(): ?string
    {
        return $this->detail;
    }

    public function setDetail(string $detail): static
    {
        $this->detail = $detail;

        return $this;
    }

    public function getAnimalId(): ?Animal
    {
        return $this->animal_id;
    }

    public function setAnimalId(?Animal $animal_id): static
    {
        $this->animal_id = $animal_id;

        return $this;
    }
}
