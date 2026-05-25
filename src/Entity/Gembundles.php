<?php

namespace App\Entity;

use App\Repository\GembundlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Gemtype;
use App\Entity\Orderitem;

#[ORM\Entity(repositoryClass: GembundlesRepository::class)]
#[ORM\Table(name: 'gembundles')]
class Gembundles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column]
    private ?int $stock = null;

    #[ORM\Column]
    private ?int $price = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    /**
     * @var Collection<int, Gemtype>
     */
    #[ORM\ManyToMany(targetEntity: Gemtype::class, inversedBy: 'gembundles')]
    #[ORM\JoinTable(name: 'webdev_gembundles_gemtype')]
    private Collection $gemtypes;

    /**
     * @var Collection<int, Orderitem>
     */
    #[ORM\OneToMany(targetEntity: Orderitem::class, mappedBy: 'gembundle')]
    private Collection $orderitems;

    public function __construct()
    {
        $this->gemtypes = new ArrayCollection();
        $this->orderitems = new ArrayCollection();
    }

    // --- Getters & Setters ---
    public function getId(): ?int { return $this->id; }
    public function setId(int $id): static { $this->id = $id; return $this; }

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    public function getDescription(): ?string { return $this->description; }
    public function setDescription(string $description): static { $this->description = $description; return $this; }

    public function getStock(): ?int { return $this->stock; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }

    public function getPrice(): ?int { return $this->price; }
    public function setPrice(int $price): static { $this->price = $price; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(string $image): static { $this->image = $image; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->created_at; }
    public function setCreatedAt(\DateTimeImmutable $created_at): static { $this->created_at = $created_at; return $this; }

    /**
     * @return Collection<int, Gemtype>
     */
    public function getGemtypes(): Collection { return $this->gemtypes; }

    public function addGemtype(Gemtype $gemtype): static
    {
        if (!$this->gemtypes->contains($gemtype)) {
            $this->gemtypes->add($gemtype);
        }
        return $this;
    }

    public function removeGemtype(Gemtype $gemtype): static
    {
        $this->gemtypes->removeElement($gemtype);
        return $this;
    }

    /**
     * @return Collection<int, Orderitem>
     */
    public function getOrderitems(): Collection { return $this->orderitems; }

    public function addOrderitem(Orderitem $orderitem): static
    {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderitems->add($orderitem);
            $orderitem->setGembundle($this);   // ✅ FIXED
        }
        return $this;
    }

    public function removeOrderitem(Orderitem $orderitem): static
    {
        if ($this->orderitems->removeElement($orderitem)) {
            if ($orderitem->getGembundle() === $this) {   // ✅ FIXED
                $orderitem->setGembundle(null);
            }
        }
        return $this;
    }
}
