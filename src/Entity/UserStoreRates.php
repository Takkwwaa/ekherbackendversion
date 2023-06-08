<?php

namespace App\Entity;

use App\Repository\UserStoreRatesRepository;
use Carbon\CarbonImmutable;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserStoreRatesRepository::class)]
class UserStoreRates
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?int $value = null;

    #[ORM\ManyToOne(inversedBy: 'userStoreRates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'userStoreRates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Store $Store = null;

    #[ORM\ManyToOne(inversedBy: 'userStoreRates')]
    #[ORM\JoinColumn(nullable: false)]
    private ?RateRule $rateRule = null;
    public function __construct()
    {
        $this->createdAt =  CarbonImmutable::now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }


    public function getValue(): ?int
    {
        return $this->value;
    }

    public function setValue(int $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getStore(): ?Store
    {
        return $this->Store;
    }

    public function setStore(?Store $Store): self
    {
        $this->Store = $Store;

        return $this;
    }

    public function getRateRule(): ?RateRule
    {
        return $this->rateRule;
    }

    public function setRateRule(?RateRule $rateRule): self
    {
        $this->rateRule = $rateRule;

        return $this;
    }
    public function __toString()
    {
        return $this->id;
    }
}
