<?php

namespace App\Entity;

use App\Repository\OrderitemRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Gem;
use App\Entity\Jewelries;
use App\Entity\Gembundles;
use App\Entity\Customjewelries;
use App\Entity\Order;

#[ORM\Entity(repositoryClass: OrderitemRepository::class)]
#[ORM\Table(name: 'orderitem')]
class Orderitem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer')]
    private ?int $quantity = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    private ?string $price_snapshot = null;

    #[ORM\ManyToOne(targetEntity: Gem::class, inversedBy: 'orderitems')]
    #[ORM\JoinColumn(name: 'gem_id', referencedColumnName: 'id')]
    private ?Gem $gem = null;

    #[ORM\ManyToOne(targetEntity: Jewelries::class, inversedBy: 'orderitems')]
    #[ORM\JoinColumn(name: 'jewelry_id', referencedColumnName: 'id')]
    private ?Jewelries $jewelry = null;

    #[ORM\ManyToOne(targetEntity: Gembundles::class, inversedBy: 'orderitems')]
    #[ORM\JoinColumn(name: 'gembundles_id', referencedColumnName: 'id')]
    private ?Gembundles $gembundle = null;

    #[ORM\ManyToOne(targetEntity: Customjewelries::class, inversedBy: 'orderitems')]
    #[ORM\JoinColumn(name: 'customjewelries_id', referencedColumnName: 'id')]
    private ?Customjewelries $customjewelries = null;


    #[ORM\ManyToOne(targetEntity: Order::class, inversedBy: 'orderitems')]
    #[ORM\JoinColumn(name: 'order_id', referencedColumnName: 'id')]
    private ?Order $order = null;

    // --- Getters & Setters ---
    public function getId(): ?int { return $this->id; }

    public function getQuantity(): ?int { return $this->quantity; }
    public function setQuantity(int $quantity): static { $this->quantity = $quantity; return $this; }

    public function getPriceSnapshot(): ?string { return $this->price_snapshot; }
    public function setPriceSnapshot(string $price_snapshot): static { $this->price_snapshot = $price_snapshot; return $this; }

    public function getGem(): ?Gem { return $this->gem; }
    public function setGem(?Gem $gem): static { $this->gem = $gem; return $this; }

    public function getJewelry(): ?Jewelries { return $this->jewelry; }
    public function setJewelry(?Jewelries $jewelry): static { $this->jewelry = $jewelry; return $this; }

    public function getGembundle(): ?Gembundles { return $this->gembundle; }
    public function setGembundle(?Gembundles $gembundle): static { $this->gembundle = $gembundle; return $this; }

    public function getCustomjewelries(): ?Customjewelries { return $this->customjewelries; }
    public function setCustomjewelries(?Customjewelries $customjewelries): static { $this->customjewelries = $customjewelries; return $this; }

    public function getOrder(): ?Order { return $this->order; }
    public function setOrder(?Order $order): static { $this->order = $order; return $this; }
}
