<?php

namespace App\Entity;

use App\Repository\ActivitylogRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ActivitylogRepository::class)]
#[ORM\Table(name: 'activity_log')]
class Activitylog
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(name: 'user_id', nullable: true)]
    private ?User $user = null;

    #[ORM\Column(length: 180, nullable: true)]
    private ?string $username = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $userRole = null;

    #[ORM\Column(length: 255)]
    private ?string $action = null;

    #[ORM\Column(type: 'text', nullable: true)]
    private ?string $targetData = null;

    #[ORM\Column(type: 'datetime_immutable')]
    private ?\DateTimeImmutable $dateTime = null;

    public function __construct()
    {
        $this->dateTime = new \DateTimeImmutable();
    }

    public function getId(): ?int { return $this->id; }

    public function getUser(): ?User { return $this->user; }
    public function setUser(?User $user): self { 
        $this->user = $user; 
        if ($user) {
            $this->username = $user->getUsername();
            $roles = $user->getRoles();
            $this->userRole = $roles[0] ?? 'ROLE_USER';
        }
        return $this; 
    }

    public function getUsername(): ?string { return $this->username; }
    public function setUsername(?string $username): self { 
        $this->username = $username; 
        return $this; 
    }

    public function getUserRole(): ?string { return $this->userRole; }
    public function setUserRole(?string $userRole): self { 
        $this->userRole = $userRole; 
        return $this; 
    }

    public function getAction(): ?string { return $this->action; }
    public function setAction(string $action): self { 
        $this->action = $action; 
        return $this; 
    }

    public function getTargetData(): ?string { return $this->targetData; }
    public function setTargetData(?string $targetData): self { 
        $this->targetData = $targetData; 
        return $this; 
    }

    public function getDateTime(): ?\DateTimeImmutable { return $this->dateTime; }
    public function setDateTime(\DateTimeImmutable $dateTime): self { 
        $this->dateTime = $dateTime; 
        return $this; 
    }
}