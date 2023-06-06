<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Repository\CategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Carbon\CarbonImmutable;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
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
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    #[Groups(['read'])]
    private ?bool $isEnabled = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read', 'write'])]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'RateRules', targetEntity: RateRule::class)]
    #[Groups(['read', 'write'])]
    private Collection $rateRule;

    #[ORM\Column]
    #[Groups(['read', 'write'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function __construct()
    {
        $this->rateRule = new ArrayCollection();
        $this->isEnabled = 1;
        $this->createdAt =  CarbonImmutable::now();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


    /**
     * @return Collection<int, RateRule>
     */
    public function getRateRule(): Collection
    {
        return $this->rateRule;
    }

    public function addRateRule(RateRule $rateRule): self
    {
        if (!$this->rateRule->contains($rateRule)) {
            $this->rateRule->add($rateRule);
            $rateRule->setRateRules($this);
        }

        return $this;
    }

    public function removeRateRule(RateRule $rateRule): self
    {
        if ($this->rateRule->removeElement($rateRule)) {
            // set the owning side to null (unless already changed)
            if ($rateRule->getRateRules() === $this) {
                $rateRule->setRateRules(null);
            }
        }

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
}
