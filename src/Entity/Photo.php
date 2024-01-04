<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use App\Repository\PhotoRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: PhotoRepository::class)]
#[Vich\Uploadable]
class Photo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $picture = null;

    #[Vich\UploadableField(mapping: 'creche_file', fileNameProperty: 'picture')]
    private ?File $picturesFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'photos')]
    private ?Creche $creche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    public function getCreche(): ?Creche
    {
        return $this->creche;
    }

    public function setCreche(?Creche $creche): static
    {
        $this->creche = $creche;

        return $this;
    }

    /**
     * Get the value of picturesFile
     */
    public function setPicturesFile(File $pictures = null)
    {
        $this->picturesFile = $pictures;
        if ($pictures) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getPicturesFile()
    {
        return $this->picturesFile;
    }

    public function getUpdatedAt(): ?DatetimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(DateTimeInterface $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
