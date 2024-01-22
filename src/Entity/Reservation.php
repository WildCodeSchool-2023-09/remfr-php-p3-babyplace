<?php

namespace App\Entity;

use App\Repository\ReservationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReservationRepository::class)]
class Reservation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creche $creche = null;

    #[ORM\ManyToOne(inversedBy: 'reservations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $family = null;

    #[ORM\OneToOne(inversedBy: 'reservation', cascade: ['persist', 'remove'])]
    private ?Calendar $Calendar = null;

    #[ORM\Column(length: 255)]
    private ?string $Status = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): static
    {
        $this->family = $family;

        return $this;
    }

    public function getCalendar(): ?Calendar
    {
        return $this->Calendar;
    }

    public function setCalendar(?Calendar $Calendar): static
    {
        $this->Calendar = $Calendar;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->Status;
    }

    public function setStatus(string $Status): static
    {
        $this->Status = $Status;

        return $this;
    }
}
