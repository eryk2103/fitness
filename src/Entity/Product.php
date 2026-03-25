<?php

namespace App\Entity;

use App\Enum\UnitType;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ORM\Table(name: 'products')]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $brand = null;

    #[ORM\Column(nullable: true)]
    private ?int $barcode = null;

    #[ORM\Column]
    private ?float $size = null;

    #[ORM\Column(nullable: true)]
    private ?float $servingSize = null;

    #[ORM\Column]
    private ?int $calories = null;

    #[ORM\Column]
    private ?float $protein = null;

    #[ORM\Column]
    private ?float $carbs = null;

    #[ORM\Column]
    private ?float $fats = null;

    #[ORM\Column(nullable: true)]
    private ?float $sugar = null;

    #[ORM\Column(options: ['default' => false])]
    private ?bool $isVerified = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    private ?User $createdBy = null;

    #[ORM\Column(enumType: UnitType::class)]
    private ?UnitType $unit = null;

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

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(?string $brand): static
    {
        $this->brand = $brand;

        return $this;
    }

    public function getBarcode(): ?int
    {
        return $this->barcode;
    }

    public function setBarcode(?int $barcode): static
    {
        $this->barcode = $barcode;

        return $this;
    }

    public function getSize(): ?float
    {
        return $this->size;
    }

    public function setSize(float $size): static
    {
        $this->size = $size;

        return $this;
    }

    public function getServingSize(): ?float
    {
        return $this->servingSize;
    }

    public function setServingSize(?float $servingSize): static
    {
        $this->servingSize = $servingSize;

        return $this;
    }

    public function getCalories(): ?int
    {
        return $this->calories;
    }

    public function setCalories(int $calories): static
    {
        $this->calories = $calories;

        return $this;
    }

    public function getProtein(): ?float
    {
        return $this->protein;
    }

    public function setProtein(float $protein): static
    {
        $this->protein = $protein;

        return $this;
    }

    public function getCarbs(): ?float
    {
        return $this->carbs;
    }

    public function setCarbs(float $carbs): static
    {
        $this->carbs = $carbs;

        return $this;
    }

    public function getFats(): ?float
    {
        return $this->fats;
    }

    public function setFats(float $fats): static
    {
        $this->fats = $fats;

        return $this;
    }

    public function getSugar(): ?float
    {
        return $this->sugar;
    }

    public function setSugar(?float $sugar): static
    {
        $this->sugar = $sugar;

        return $this;
    }

    public function isVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getUnit(): ?UnitType
    {
        return $this->unit;
    }

    public function setUnit(UnitType $unit): static
    {
        $this->unit = $unit;

        return $this;
    }
}
