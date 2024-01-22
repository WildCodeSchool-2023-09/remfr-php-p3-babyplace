<?php

namespace App\Entity;

use App\Repository\CalendarRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CalendarRepository::class)]
class Calendar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message:"Le titre ne peut pas être vide")]
    #[Assert\Length(
        min:3,
        max:100,
        minMessage:"Le titre doit contenir au moins {{ limit }} caractères",
        maxMessage:"Le titre ne peut pas dépasser {{ limit }} caractères"
    )]
    private ?string $title = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message:"La date de début ne peut pas être vide")]
    private ?\DateTimeInterface $start = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    #[Assert\NotNull(message:"La date de fin ne peut pas être vide")]
    private ?\DateTimeInterface $end = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(nullable: true)]
    private ?bool $allDay = null;

    #[ORM\Column(length: 7)]
    #[Assert\Regex(
        pattern:"/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/",
        message:"La couleur de fond doit être au format hexadécimal (#RRGGBB ou #RGB)"
    )]
    private ?string $backgroundColor = null;

    #[ORM\Column(length: 7)]
    #[Assert\Regex(
        pattern:"/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/",
        message:"La couleur de fond doit être au format hexadécimal (#RRGGBB ou #RGB)"
    )]
    private ?string $textColor = null;

    #[ORM\ManyToOne(inversedBy: 'calendars')]
    private ?creche $Creche = null;

    #[ORM\OneToOne(mappedBy: 'Calendar', cascade: ['persist', 'remove'])]
    private ?Reservation $reservation = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getStart(): ?\DateTimeInterface
    {
        return $this->start;
    }

    public function setStart(\DateTimeInterface $start): static
    {
        $this->start = $start;

        return $this;
    }

    public function getEnd(): ?\DateTimeInterface
    {
        return $this->end;
    }

    public function setEnd(\DateTimeInterface $end): static
    {
        $this->end = $end;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function setAllDay(bool $allDay): static
    {
        $this->allDay = $allDay;

        return $this;
    }

    public function getBackgroundColor(): ?string
    {
        return $this->backgroundColor;
    }

    public function setBackgroundColor(string $backgroundColor): static
    {
        $this->backgroundColor = $backgroundColor;

        return $this;
    }

    public function getTextColor(): ?string
    {
        return $this->textColor;
    }

    public function setTextColor(string $textColor): static
    {
        $this->textColor = $textColor;

        return $this;
    }

    /**
     * Get the value of all_day
     */
    public function getAllDay(): ?bool
    {
        return $this->allDay;
    }

    public function getCreche(): ?creche
    {
        return $this->Creche;
    }

    public function setCreche(?creche $Creche): static
    {
        $this->Creche = $Creche;

        return $this;
    }

    public function getReservation(): ?Reservation
    {
        return $this->reservation;
    }

    public function setReservation(?Reservation $reservation): static
    {
        // unset the owning side of the relation if necessary
        if ($reservation === null && $this->reservation !== null) {
            $this->reservation->setCalendar(null);
        }

        // set the owning side of the relation if necessary
        if ($reservation !== null && $reservation->getCalendar() !== $this) {
            $reservation->setCalendar($this);
        }

        $this->reservation = $reservation;

        return $this;
    }
}
