<?php

namespace App\Entity;
use ApiPlatform\Metadata\ApiResource;
use App\Repository\GemRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Serializer\Annotation\Groups; // ADD THIS LINE
use App\Entity\Gemtype;
use App\Entity\Orderitem;

#[ORM\Entity(repositoryClass: GemRepository::class)]
#[ORM\Table(name: 'gem')]
#[ApiResource]
class Gem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['gem:read'])] // ADD THIS - for reading ID
    private ?int $id = null;

    #[ORM\Column(type: 'float')]
    #[Assert\NotBlank(message: 'Carat is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS - for reading and writing
    private ?float $carat = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Size is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $size = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Cut is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $cut = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Color is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $color = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Clarity is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $clarity = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: 'Origin is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $origin = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Description is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Stock is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?int $stock = null;

    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Assert\NotBlank(message: 'Price is required')]
    #[Groups(['gem:read', 'gem:write'])] // ADD THIS
    private ?string $price = null;

    #[ORM\ManyToOne(targetEntity: Gemtype::class, inversedBy: 'gems')]
    #[ORM\JoinColumn(name: 'gemtype_id', referencedColumnName: 'id')]
    #[Groups(['gem:read'])] // ADD THIS - only for reading, not writing
    private ?Gemtype $gemtype = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    #[Groups(['gem:read'])] // ADD THIS - only for reading
    private ?string $imagepath = null;

    /**
     * @var Collection<int, Orderitem>
     */
    #[ORM\OneToMany(targetEntity: Orderitem::class, mappedBy: 'gem')]
    // Be careful with this - it could cause circular references
    // You might want to handle this separately
    private Collection $orderitems;

    public function __construct()
    {
        $this->orderitems = new ArrayCollection();
    }

    // ---------------- GETTERS & SETTERS ---------------- //

    public function getId(): ?int 
    { 
        return $this->id; 
    }

    public function getCarat(): ?float 
    { 
        return $this->carat; 
    }
    
    public function setCarat(float $carat): static 
    { 
        $this->carat = $carat; 
        return $this; 
    }

    public function getSize(): ?string 
    { 
        return $this->size; 
    }
    
    public function setSize(string $size): static 
    { 
        $this->size = $size; 
        return $this; 
    }

    public function getCut(): ?string 
    { 
        return $this->cut; 
    }
    
    public function setCut(string $cut): static 
    { 
        $this->cut = $cut; 
        return $this; 
    }

    public function getColor(): ?string 
    { 
        return $this->color; 
    }
    
    public function setColor(string $color): static 
    { 
        $this->color = $color; 
        return $this; 
    }

    public function getClarity(): ?string 
    { 
        return $this->clarity; 
    }
    
    public function setClarity(string $clarity): static 
    { 
        $this->clarity = $clarity; 
        return $this; 
    }

    public function getOrigin(): ?string 
    { 
        return $this->origin; 
    }
    
    public function setOrigin(string $origin): static 
    { 
        $this->origin = $origin; 
        return $this; 
    }

    public function getDescription(): ?string 
    { 
        return $this->description; 
    }
    
    public function setDescription(string $description): static 
    { 
        $this->description = $description; 
        return $this; 
    }

    public function getStock(): ?int 
    { 
        return $this->stock; 
    }
    
    public function setStock(int $stock): static 
    { 
        $this->stock = $stock; 
        return $this; 
    }

    public function getPrice(): ?string 
    { 
        return $this->price; 
    }
    
    public function setPrice(string $price): static 
    { 
        $this->price = $price; 
        return $this; 
    }

    public function getImagepath(): ?string 
    { 
        return $this->imagepath; 
    }
    
    public function setImagepath(?string $imagepath): static 
    { 
        $this->imagepath = $imagepath; 
        return $this; 
    }

    public function getGemtype(): ?Gemtype 
    { 
        return $this->gemtype; 
    }
    
    public function setGemtype(?Gemtype $gemtype): static 
    { 
        $this->gemtype = $gemtype; 
        return $this; 
    }

    /**
     * @return Collection<int, Orderitem>
     */
    public function getOrderitems(): Collection 
    { 
        return $this->orderitems; 
    }

    public function addOrderitem(Orderitem $orderitem): static
    {
        if (!$this->orderitems->contains($orderitem)) {
            $this->orderitems->add($orderitem);
            $orderitem->setGem($this);
        }
        return $this;
    }

    public function removeOrderitem(Orderitem $orderitem): static
    {
        if ($this->orderitems->removeElement($orderitem)) {
            if ($orderitem->getGem() === $this) {
                $orderitem->setGem(null);
            }
        }
        return $this;
    }

    // OPTIONAL: Add a __toString method for easy debugging
    public function __toString(): string
    {
        return $this->getCarat() . 'ct ' . $this->getColor() . ' ' . $this->getCut();
    }
}