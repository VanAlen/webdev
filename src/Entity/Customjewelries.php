<?php

namespace App\Entity;

use App\Entity\Gemtype;
use App\Entity\Jewelrytype;
use App\Entity\Orderitem;
use App\Entity\User;
use App\Repository\CustomjewelriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CustomjewelriesRepository::class)]
#[ORM\Table(name: 'customjewelries')]
class Customjewelries
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $notes = null;

    #[ORM\Column(length: 255)]
    private ?string $imagepath = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $created_at = null;

    #[ORM\ManyToOne(targetEntity: Gemtype::class, inversedBy: 'customjewelries')]
    #[ORM\JoinColumn(name: 'gemtype_id', referencedColumnName: 'id')]
    private ?Gemtype $gemtype = null;

    #[ORM\ManyToOne(targetEntity: Jewelrytype::class, inversedBy: 'customjewelries')]
    #[ORM\JoinColumn(name: 'jewelrytype_id', referencedColumnName: 'id')]
    private ?Jewelrytype $jewelrytype = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'customer_id', referencedColumnName: 'id', nullable: false)]
    private ?User $customer = null;

    /**
     * @var Collection<int, Orderitem>
     */
    #[ORM\OneToMany(targetEntity: Orderitem::class, mappedBy: 'customjewelries')]
    private Collection $orderitems;

    public function __construct()
    {
        $this->orderitems = new ArrayCollection();
    }

    // ----- Getters/Setters -----
    public function getId(): ?int { return $this->id; }

    public function getNotes(): ?string { return $this->notes; }
    public function setNotes(string $notes): static { $this->notes = $notes; return $this; }

    public function getImagepath(): ?string { return $this->imagepath; }
    public function setImagepath(?string $imagepath): static { $this->imagepath = $imagepath; return $this; }

    public function getCreatedAt(): ?\DateTimeImmutable { return $this->created_at; }
    public function setCreatedAt(\DateTimeImmutable $created_at): static { $this->created_at = $created_at; return $this; }

    public function getGemtype(): ?Gemtype { return $this->gemtype; }
    public function setGemtype(?Gemtype $gemtype): static { $this->gemtype = $gemtype; return $this; }

    public function getJewelrytype(): ?Jewelrytype { return $this->jewelrytype; }
    public function setJewelrytype(?Jewelrytype $jewelrytype): static { $this->jewelrytype = $jewelrytype; return $this; }

    public function getCustomer(): ?User { return $this->customer; }
    public function setCustomer(?User $customer): static { $this->customer = $customer; return $this; }

    /**
     * @return Collection<int, Orderitem>
     */
    public function getOrderitems(): Collection { return $this->orderitems; }

    public function addOrderitem(Orderitem $orderitem): static
    {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderitems->add($orderitem);
            $orderitem->setCustomjewelries($this);
        }
        return $this;
    }

    public function removeOrderitem(Orderitem $orderitem): static
    {
        if ($this->orderitems->removeElement($orderitem)) {
            if ($orderitem->getCustomjewelries() === $this) {
                $orderitem->setCustomjewelries(null);
            }
        }
        return $this;
    }
}
