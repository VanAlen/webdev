<?php

namespace App\Entity;

use App\Repository\GemtypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customjewelries;
use App\Entity\Gembundles;
use App\Entity\Gem;
use App\Entity\Jewelries;

#[ORM\Entity(repositoryClass: GemtypeRepository::class)]
#[ORM\Table(name: 'gemtype')]
class Gemtype
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Customjewelries>
     */
    #[ORM\OneToMany(mappedBy: 'gemtype', targetEntity: Customjewelries::class)]
    private Collection $customjewelries;

    /**
     * @var Collection<int, Gembundles>
     */
    #[ORM\ManyToMany(targetEntity: Gembundles::class, mappedBy: 'gemtypes')]
    private Collection $gembundles;

    /**
     * @var Collection<int, Gem>
     */
    #[ORM\OneToMany(mappedBy: 'gemtype', targetEntity: Gem::class)]
    private Collection $gems;

    /**
     * @var Collection<int, Jewelries>
     */
    #[ORM\OneToMany(mappedBy: 'gemtype', targetEntity: Jewelries::class)]
    private Collection $jewelries;

    public function __construct()
    {
        $this->customjewelries = new ArrayCollection();
        $this->gembundles = new ArrayCollection();
        $this->gems = new ArrayCollection();
        $this->jewelries = new ArrayCollection();
    }

    // --- ID & Name ---
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): static { $this->id = $id; return $this; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    // --- Customjewelries ---
    public function getCustomjewelries(): Collection { return $this->customjewelries; }
    public function addCustomjewelry(Customjewelries $customjewelry): static
    {
        if (!$this->customjewelries->contains($customjewelry)) {
            $this->customjewelries->add($customjewelry);
            $customjewelry->setGemtype($this);
        }
        return $this;
    }
    public function removeCustomjewelry(Customjewelries $customjewelry): static
    {
        if ($this->customjewelries->removeElement($customjewelry)) {
            if ($customjewelry->getGemtype() === $this) {
                $customjewelry->setGemtype(null);
            }
        }
        return $this;
    }

    // --- Gembundles ---
    public function getGembundles(): Collection { return $this->gembundles; }
    public function addGembundle(Gembundles $gembundle): static
    {
        if (!$this->gembundles->contains($gembundle)) {
            $this->gembundles->add($gembundle);
            $gembundle->addGemtype($this);
        }
        return $this;
    }
    public function removeGembundle(Gembundles $gembundle): static
    {
        if ($this->gembundles->removeElement($gembundle)) {
            $gembundle->removeGemtype($this);
        }
        return $this;
    }

    // --- Gems ---
    public function getGems(): Collection { return $this->gems; }
    public function addGem(Gem $gem): static
    {
        if (!$this->gems->contains($gem)) {
            $this->gems->add($gem);
            $gem->setGemtype($this);
        }
        return $this;
    }
    public function removeGem(Gem $gem): static
    {
        if ($this->gems->removeElement($gem)) {
            if ($gem->getGemtype() === $this) {
                $gem->setGemtype(null);
            }
        }
        return $this;
    }

    // --- Jewelries ---
    public function getJewelries(): Collection { return $this->jewelries; }
    public function addJewelry(Jewelries $jewelry): static
    {
        if (!$this->jewelries->contains($jewelry)) {
            $this->jewelries->add($jewelry);
            $jewelry->setGemtype($this);
        }
        return $this;
    }
    public function removeJewelry(Jewelries $jewelry): static
    {
        if ($this->jewelries->removeElement($jewelry)) {
            if ($jewelry->getGemtype() === $this) {
                $jewelry->setGemtype(null);
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
