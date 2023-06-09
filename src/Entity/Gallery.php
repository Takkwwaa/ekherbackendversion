<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use App\Repository\GalleryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: GalleryRepository::class)]
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
class Gallery
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read'])]
    private ?int $id = null;



    #[ORM\OneToOne(mappedBy: 'gallery', cascade: ['persist', 'remove'])]
    #[Groups(['read', 'write'])]
    private ?Store $store = null;

    #[ORM\OneToMany(mappedBy: 'gallery', targetEntity: picture::class)]
    private Collection $Pictures;

    public function __construct()
    {
        $this->Pictures = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }



    public function getStore(): ?Store
    {
        return $this->store;
    }

    public function setStore(?Store $store): self
    {
        // unset the owning side of the relation if necessary
        if ($store === null && $this->store !== null) {
            $this->store->setGallery(null);
        }

        // set the owning side of the relation if necessary
        if ($store !== null && $store->getGallery() !== $this) {
            $store->setGallery($this);
        }

        $this->store = $store;

        return $this;
    }

    /**
     * @return Collection<int, picture>
     */
    public function getPictures(): Collection
    {
        return $this->Pictures;
    }

    public function addPicture(picture $picture): self
    {
        if (!$this->Pictures->contains($picture)) {
            $this->Pictures->add($picture);
            $picture->setGallery($this);
        }

        return $this;
    }

    public function removePicture(picture $picture): self
    {
        if ($this->Pictures->removeElement($picture)) {
            // set the owning side to null (unless already changed)
            if ($picture->getGallery() === $this) {
                $picture->setGallery(null);
            }
        }

        return $this;
    }
}
