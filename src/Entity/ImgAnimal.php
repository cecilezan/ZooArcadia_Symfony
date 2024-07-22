<?php

namespace App\Entity;

use App\Repository\ImgAnimalRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ImgAnimalRepository::class)]
class ImgAnimal
{
    #[ORM\Id]
    #[ORM\GeneratedValue (strategy:"IDENTITY")]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    private ?string $image_data = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getImageData(): ?string
    {
        return $this->image_data;
    }

    public function setImageData(string $image_data): static
    {
        $this->image_data = $image_data;

        return $this;
    }
}
