<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\TeamRepository;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
#[Vich\Uploadable]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le prénom de l\'équipier')]
    #[Assert\Length(max: 255, maxMessage: 'Le prénom de l\'équipier ne peut pas dépasser 255 caractères')]
    private ?string $teamFirstname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le nom de l\'équipier')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom de l\'équipier ne peut pas dépasser 255 caractères')]
    private ?string $teamLastname = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner la fonction de l\'équipier')]
    #[Assert\Length(max: 255, maxMessage: 'La fonction de l\'équipier ne peut pas dépasser 255 caractères')]
    private ?string $fonction = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $photo = null;

    #[Vich\UploadableField(mapping: 'team_file', fileNameProperty: 'photo')]
    private ?File $teamAvatarFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'teams', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creche $creche = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamFirstname(): ?string
    {
        return $this->teamFirstname;
    }

    public function setTeamFirstname(string $teamFirstname): static
    {
        $this->teamFirstname = $teamFirstname;

        return $this;
    }

    public function getTeamLastname(): ?string
    {
        return $this->teamLastname;
    }

    public function setTeamLastname(string $teamLastname): static
    {
        $this->teamLastname = $teamLastname;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->fonction;
    }

    public function setFonction(string $fonction): static
    {
        $this->fonction = $fonction;

        return $this;
    }

    public function getPhoto(): ?string
    {
        return $this->photo;
    }

    public function setPhoto(string $photo): self
    {
        $this->photo = $photo;

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


    public function setTeamAvatarFile(File $image = null): Team
    {
        $this->teamAvatarFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    public function getTeamAvatarFile(): ?File
    {
        return $this->teamAvatarFile;
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
