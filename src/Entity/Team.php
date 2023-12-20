<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $teamFirstname = null;

    #[ORM\Column(length: 255)]
    private ?string $teamLastname = null;

    #[ORM\Column(length: 255)]
    private ?string $fonction = null;

    #[ORM\Column(length: 255)]
    private ?string $photo = null;

    #[ORM\ManyToOne(inversedBy: 'teams')]
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

    public function setPhoto(string $photo): static
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
}
