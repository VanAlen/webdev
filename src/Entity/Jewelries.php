<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\JewelriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;  // ADD THIS
use App\Entity\Gemtype;
use App\Entity\Jewelrytype;
use App\Entity\Orderitem;

#[ORM\Entity(repositoryClass: JewelriesRepository::class)]
#[ORM\Table(name: 'jewelries')]
#[ApiResource(
    normalizationContext: ['groups' => ['jewelry:read']],
    denormalizationContext: ['groups' => ['jewelry:write']]
)]
class Jewelries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['jewelry:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['jewelry:read', 'jewelry:write'])]
    private ?string $name = null;

    #[ORM\ManyToOne(targetEntity: Gemtype::class, inversedBy: 'jewelries')]
    #[ORM\JoinColumn(name: 'gemtype_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['jewelry:read'])]
    private ?Gemtype $gemtype = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]  // Changed to 2 decimal places
    #[Groups(['jewelry:read', 'jewelry:write'])]
    private ?string $price = null;

    #[ORM\Column]
    #[Groups(['jewelry:read', 'jewelry:write'])]
    private ?int $stock = null;

    #[ORM\ManyToOne(targetEntity: Jewelrytype::class, inversedBy: 'jewelries')]
    #[ORM\JoinColumn(name: 'jewelrytype_id', referencedColumnName: 'id', nullable: true)]
    #[Groups(['jewelry:read'])]
    private ?Jewelrytype $jewelrytype = null;

    #[ORM\Column(length: 255)]
    #[Groups(['jewelry:read', 'jewelry:write'])]
    private ?string $image = null;

    /**
     * @var Collection<int, Orderitem>
     */
    #[ORM\OneToMany(targetEntity: Orderitem::class, mappedBy: 'jewelry')]
    private Collection $orderitems;

    public function __construct()
    {
        $this->orderitems = new ArrayCollection();
    }

    // --- Getters & Setters (NO setId method!) ---
    public function getId(): ?int { return $this->id; }
    // ❌ REMOVE setId() COMPLETELY

    public function getName(): ?string { return $this->name; }
    public function setName(string $name): static { $this->name = $name; return $this; }

    public function getGemtype(): ?Gemtype { return $this->gemtype; }
    public function setGemtype(?Gemtype $gemtype): static { $this->gemtype = $gemtype; return $this; }

    public function getPrice(): ?string { return $this->price; }
    public function setPrice(string $price): static { $this->price = $price; return $this; }

    public function getStock(): ?int { return $this->stock; }
    public function setStock(int $stock): static { $this->stock = $stock; return $this; }

    public function getJewelrytype(): ?Jewelrytype { return $this->jewelrytype; }
    public function setJewelrytype(?Jewelrytype $jewelrytype): static { $this->jewelrytype = $jewelrytype; return $this; }

    public function getImage(): ?string { return $this->image; }
    public function setImage(string $image): static { $this->image = $image; return $this; }

    /**
     * @return Collection<int, Orderitem>
     */
    public function getOrderitems(): Collection { return $this->orderitems; }

    public function addOrderitem(Orderitem $orderitem): static
    {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderitems->add($orderitem);
            $orderitem->setJewelry($this);
        }
        return $this;
    }

    public function removeOrderitem(Orderitem $orderitem): static
    {
        if ($this->orderitems->removeElement($orderitem)) {
            if ($orderitem->getJewelry() === $this) {
                $orderitem->setJewelry(null);
            }
        }
        return $this;
    }
}