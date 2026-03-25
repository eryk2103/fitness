<?php

namespace App\Entity;

use App\Repository\DailyLogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: DailyLogRepository::class)]
class DailyLog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'dailyLogs')]
    private ?User $owner = null;

    #[ORM\Column]
    private ?int $caloriesGoal = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $date = null;

    /**
     * @var Collection<int, ProductEntry>
     */
    #[ORM\OneToMany(targetEntity: ProductEntry::class, mappedBy: 'dailyLog')]
    private Collection $productEntries;

    public function __construct()
    {
        $this->productEntries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOwner(): ?User
    {
        return $this->owner;
    }

    public function setOwner(?User $owner): static
    {
        $this->owner = $owner;

        return $this;
    }

    public function getCaloriesGoal(): ?int
    {
        return $this->caloriesGoal;
    }

    public function setCaloriesGoal(int $caloriesGoal): static
    {
        $this->caloriesGoal = $caloriesGoal;

        return $this;
    }

    public function getDate(): ?\DateTimeImmutable
    {
        return $this->date;
    }

    public function setDate(\DateTimeImmutable $date): static
    {
        $this->date = $date;

        return $this;
    }

    /**
     * @return Collection<int, ProductEntry>
     */
    public function getProductEntries(): Collection
    {
        return $this->productEntries;
    }

    public function addProductEntry(ProductEntry $productEntry): static
    {
        if (!$this->productEntries->contains($productEntry)) {
            $this->productEntries->add($productEntry);
            $productEntry->setDailyLog($this);
        }

        return $this;
    }

    public function removeProductEntry(ProductEntry $productEntry): static
    {
        if ($this->productEntries->removeElement($productEntry)) {
            // set the owning side to null (unless already changed)
            if ($productEntry->getDailyLog() === $this) {
                $productEntry->setDailyLog(null);
            }
        }

        return $this;
    }
}
