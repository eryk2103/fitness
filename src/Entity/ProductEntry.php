<?php

namespace App\Entity;

use App\Repository\ProductEntryRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ProductEntryRepository::class)]
#[ORM\Table(name: 'product_entries')]
class ProductEntry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne]
    #[Assert\NotBlank]
    private ?Product $product = null;

    #[ORM\ManyToOne(inversedBy: 'productEntries')]
    private ?DailyLog $dailyLog = null;

    #[ORM\Column]
    #[Assert\NotBlank]
    #[Assert\Positive(message: "Quantity must be positive.")]
    private ?float $quantity = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): static
    {
        $this->product = $product;

        return $this;
    }

    public function getDailyLog(): ?DailyLog
    {
        return $this->dailyLog;
    }

    public function setDailyLog(?DailyLog $dailyLog): static
    {
        $this->dailyLog = $dailyLog;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): static
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCalories(): ?int 
    {
        $calories = $this->getProduct()->getCalories();
        $quantity = $this->getQuantity();
            
        return $calories * $quantity / 100;
    }
}
