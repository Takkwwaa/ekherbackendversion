<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\RateRuleRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Carbon\CarbonImmutable;

#[ORM\Entity(repositoryClass: RateRuleRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['read']],
    denormalizationContext: ['groups' => ['write']],
)]
#[Get(outputFormats: ["json"])]
#[Post()]
#[Put()]
#[Patch()]
#[Delete()]
#[GetCollection(outputFormats: ["json"])]
class RateRule
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $lable = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?bool $isEnabled = null;

    #[ORM\ManyToOne(inversedBy: 'rateRule')]
    #[Groups(['read'])]
    private ?Category $RateRules = null;

    public function __construct()
    {
        $this->isEnabled = 1;
        $this->createdAt =  CarbonImmutable::now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLable(): ?string
    {
        return $this->lable;
    }

    public function setLable(string $lable): self
    {
        $this->lable = $lable;

        return $this;
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

    public function isIsEnabled(): ?bool
    {
        return $this->isEnabled;
    }

    public function setIsEnabled(bool $isEnabled): self
    {
        $this->isEnabled = $isEnabled;

        return $this;
    }

    public function getRateRules(): ?Category
    {
        return $this->RateRules;
    }

    public function setRateRules(?Category $RateRules): self
    {
        $this->RateRules = $RateRules;

        return $this;
    }
}
