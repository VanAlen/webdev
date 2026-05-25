<?php

namespace App\Entity;

use App\Repository\JewelrytypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Jewelries;
use App\Entity\Customjewelries;

#[ORM\Entity(repositoryClass: JewelrytypeRepository::class)]
#[ORM\Table(name: 'jewelrytype')]
class Jewelrytype
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Jewelries>
     */
    #[ORM\OneToMany(mappedBy: 'jewelrytype', targetEntity: Jewelries::class)]
    private Collection $jewelries;

    /**
     * @var Collection<int, Customjewelries>
     */
    #[ORM\OneToMany(mappedBy: 'jewelrytype', targetEntity: Customjewelries::class)]
    private Collection $customjewelries;

    public function __construct()
    {
        $this->jewelries = new ArrayCollection();
        $this->customjewelries = new ArrayCollection();
    }

    // --- ID & Name ---
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;
        return $this;
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

    // --- Jewelries ---
    /**
     * @return Collection<int, Jewelries>
     */
    public function getJewelries(): Collection
    {
        return $this->jewelries;
    }

    public function addJewelry(Jewelries $jewelry): static
    {
        if (!$this->jewelries->contains($jewelry)) {
            $this->jewelries->add($jewelry);
            $jewelry->setJewelrytype($this);
        }
        return $this;
    }

    public function removeJewelry(Jewelries $jewelry): static
    {
        if ($this->jewelries->removeElement($jewelry)) {
            if ($jewelry->getJewelrytype() === $this) {
                $jewelry->setJewelrytype(null);
            }
        }
        return $this;
    }

    // --- Customjewelries ---
    /**
     * @return Collection<int, Customjewelries>
     */
    public function getCustomjewelries(): Collection
    {
        return $this->customjewelries;
    }

    public function addCustomjewelry(Customjewelries $customjewelry): static
    {
        if (!$this->customjewelries->contains($customjewelry)) {
            $this->customjewelries->add($customjewelry);
            $customjewelry->setJewelrytype($this);
        }
        return $this;
    }

    public function removeCustomjewelry(Customjewelries $customjewelry): static
    {
        if ($this->customjewelries->removeElement($customjewelry)) {
            if ($customjewelry->getJewelrytype() === $this) {
                $customjewelry->setJewelrytype(null);
            }
        }
        return $this;
    }

    // --- String representation for Twig & forms ---
    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
