<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Entity\Order;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'user')]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[UniqueEntity(fields: ['username'], message: 'There is already an account with this username')]
#[UniqueEntity(fields: ['email'], message: 'There is already an account with this email address')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column(type: 'json')]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Assert\Length(
        min: 3,
        minMessage: 'Your password must be at least {{ limit }} characters long',
        max: 4096
    )]
    private ?string $password = null;
    
    /**
     * @var Collection<int, Order>
     */
    #[ORM\OneToMany(targetEntity: Order::class, mappedBy: 'customer')]
    private Collection $orders;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateCreated = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $status = 'active';

    #[ORM\Column(length: 255, unique: true, nullable: true)]
    private ?string $email = null;
    
    #[ORM\Column]
    private ?bool $isVerified = false ;
    
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $verificationToken = null;

    #[ORM\Column(name: "first_name", length: 255, nullable: true)]
    private ?string $firstName = null;

    #[ORM\Column(name: "last_name", length: 255, nullable: true)]
    private ?string $lastName = null;

    #[ORM\Column(name: "age", nullable: true)]
    private ?int $age = null;

    #[ORM\Column(name: "address", length: 255, nullable: true)]
    private ?string $address = null;

    #[ORM\Column(name: "profile_image", length: 255, nullable: true)]
    private ?string $profileImage = null;

    public function __construct()
    {
        $this->orders = new ArrayCollection();
        $this->dateCreated = new \DateTimeImmutable();
        $this->status = 'active';
        $this->roles = ['ROLE_USER'];
    }

    // --- Getters and Setters ---
    public function getId(): ?int { return $this->id; }

    public function getUsername(): ?string { return $this->username; }
    public function setUsername(string $username): static { $this->username = $username; return $this; }

    public function getUserIdentifier(): string { return (string) $this->username; }

    public function getRoles(): array
    {
        $roles = $this->roles;
        $roles[] = 'ROLE_USER';
        return array_unique($roles);
    }

    public function setRoles(array $roles): static { $this->roles = $roles; return $this; }

    public function getPassword(): ?string { return $this->password; }
    public function setPassword(string $password): static { $this->password = $password; return $this; }

    public function eraseCredentials(): void {}

    public function __serialize(): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'roles' => $this->roles,
        ];
    }

    public function getOrders(): Collection { return $this->orders; }

    public function addOrder(Order $order): static
    {
        if (!$this->orders->contains($order)) {
            $this->orders->add($order);
            $order->setCustomer($this);
        }
        return $this;
    }

    public function removeOrder(Order $order): static
    {
        if ($this->orders->removeElement($order)) {
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }
        return $this;
    }

    public function getDateCreated(): ?\DateTimeImmutable { return $this->dateCreated; }
    public function setDateCreated(\DateTimeImmutable $dateCreated): static { $this->dateCreated = $dateCreated; return $this; }

    public function getStatus(): ?string { return $this->status; }
    public function setStatus(?string $status): static { $this->status = $status; return $this; }

    public function getEmail(): ?string { return $this->email; }
    public function setEmail(string $email): static { $this->email = $email; return $this; }

    public function isVerified(): ?bool { return $this->isVerified; }
    public function setIsVerified(bool $isVerified): static { $this->isVerified = $isVerified; return $this; }

    public function getVerificationToken(): ?string { return $this->verificationToken; }
    public function setVerificationToken(?string $verificationToken): static { $this->verificationToken = $verificationToken; return $this; }

    public function getFirstName(): ?string { return $this->firstName; }
    public function setFirstName(string $firstName): static { $this->firstName = $firstName; return $this; }

    public function getLastName(): ?string { return $this->lastName; }
    public function setLastName(string $lastName): static { $this->lastName = $lastName; return $this; }

    public function getAge(): ?int { return $this->age; }
    public function setAge(int $age): static { $this->age = $age; return $this; }

    public function getAddress(): ?string { return $this->address; }
    public function setAddress(string $address): static { $this->address = $address; return $this; }

    public function getProfileImage(): ?string { return $this->profileImage; }
    public function setProfileImage(string $profileImage): static { $this->profileImage = $profileImage; return $this; }
}