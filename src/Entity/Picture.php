<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\PictureRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use Symfony\Component\Serializer\Annotation\Groups;


#[ORM\Entity(repositoryClass: PictureRepository::class)]
#[ApiResource(
    normalizationContext: ["groups" => ["read"]],
    denormalizationContext: ["groups" => ["write"]]
)]
#[Get(outputFormats: ["json"])]
#[Post()]
#[Put(inputFormats: ['multipart' => ['multipart/form-data']])]
#[Patch(inputFormats: ['multipart' => ['multipart/form-data']])]
#[Delete()]
#[Post(inputFormats: ['multipart' => ['multipart/form-data']])]
#[Vich\Uploadable]
class Picture
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(["read"])]
    private ?int $id = null;

    // NOTE: This is not a mapped field of entity metadata, just a simple property.
    #[Vich\UploadableField(mapping: 'picture', fileNameProperty: 'imageName', size: 'imageSize')]
    #[Groups(["read"], ["write"])]
    private ?File $imageFile = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read"])]
    private ?string $imageName = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read"])]
    private ?int $imageSize = null;

    #[ORM\Column(nullable: true)]
    #[Groups(["read"])]
    private ?\DateTimeImmutable $updatedAt = null;


    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    #[ORM\OneToOne(inversedBy: 'logo', cascade: ['persist', 'remove'])]
    private ?Store $store = null;

    #[ORM\OneToOne(inversedBy: 'avatar', cascade: ['remove'])]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'Pictures')]
    private ?Gallery $gallery = null;
    public function __construct()
    {
        $this->imageFile = null;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStore(): ?Store
    {
        return $this->store;
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
    public function setStore(?Store $store): self
    {
        $this->store = $store;

        return $this;
    }
    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }

    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getGallery(): ?Gallery
    {
        return $this->gallery;
    }

    public function setGallery(?Gallery $gallery): self
    {
        $this->gallery = $gallery;

        return $this;
    }
}
