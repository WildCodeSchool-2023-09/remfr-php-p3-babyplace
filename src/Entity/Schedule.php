<?php

namespace App\Entity;

use App\Repository\ScheduleRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ScheduleRepository::class)]
class Schedule
{
    public const DAYS = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche',
    ];
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $weekdays = null;

    #[ORM\Column(length: 255)]
    private ?string $openingHours = null;

    #[ORM\Column(length: 255)]
    private ?string $closingHours = null;

    #[ORM\OneToOne(inversedBy: 'schedule', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Creche $creche = null;

    #[ORM\OneToMany(mappedBy: 'agenda', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getWeekdays(): ?string
    {
        return $this->weekdays;
    }

    public function setWeekdays(string $weekdays): static
    {
        $this->weekdays = $weekdays;

        return $this;
    }

    public function getOpeningHours(): ?string
    {
        return $this->openingHours;
    }

    public function setOpeningHours(string $openingHours): static
    {
        $this->openingHours = $openingHours;

        return $this;
    }

    public function getClosingHours(): ?string
    {
        return $this->closingHours;
    }

    public function setClosingHours(string $closingHours): static
    {
        $this->closingHours = $closingHours;

        return $this;
    }

    public function getCreche(): ?Creche
    {
        return $this->creche;
    }

    public function setCreche(Creche $creche): static
    {
        $this->creche = $creche;

        return $this;
    }

    /**
     * @return Collection<int, Reservation>
     */
    public function getReservations(): Collection
    {
        return $this->reservations;
    }

    public function addReservation(Reservation $reservation): static
    {
        if (!$this->reservations->contains($reservation)) {
            $this->reservations->add($reservation);
            $reservation->setAgenda($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getAgenda() === $this) {
                $reservation->setAgenda(null);
            }
        }

        return $this;
    }
}
