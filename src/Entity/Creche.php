<?php

namespace App\Entity;

use App\Repository\CrecheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CrecheRepository::class)]
class Creche
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Assert\NotBlank(message: 'Veuillez renseigner l\'introduction de la crèche')]
    #[Assert\Length(min: 10, minMessage: 'L\'introduction doit contenir au moins 10 caractères'),
    Assert\Length(max: 255, maxMessage: 'L\'introduction doit contenir au maximum 255 caractères')]
    private ?string $introduction = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le nom de la crèche')]
    #[Assert\Length(max: 255, maxMessage: 'Le nom de la crèche doit contenir au maximum 255 caractères')]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner la localisation de la crèche')]
    #[Assert\Length(max: 255, maxMessage: 'La localisation de la crèche doit contenir au maximum 255 caractères')]
    private ?string $localisation = null;

    #[ORM\Column]
    #[Assert\NotBlank(message: 'Veuillez renseigner le code postal de la crèche')]
    private ?int $postCode = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner la ville de la crèche')]
    private ?string $city = null;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le numéro de téléphone de la crèche')]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 20)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le numéro d\'assurance de la crèche')]
    private ?string $insuranceNumber = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Veuillez renseigner le statut juridique de la crèche')]
    private ?string $legalStatus = null;

    #[ORM\OneToOne(inversedBy: 'creche', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'creche', targetEntity: Team::class, orphanRemoval: true)]
    private Collection $teams;

    #[ORM\OneToMany(mappedBy: 'creche', targetEntity: Photo::class)]
    private Collection $photos;

    #[ORM\ManyToMany(targetEntity: Administration::class, mappedBy: 'creche')]
    private Collection $administrations;

    #[ORM\ManyToMany(targetEntity: Child::class, mappedBy: 'creche')]
    private Collection $children;

    #[ORM\OneToOne(mappedBy: 'creche', cascade: ['persist', 'remove'])]
    private ?Schedule $schedule = null;

    #[ORM\OneToMany(mappedBy: 'creche', targetEntity: Service::class)]
    private Collection $services;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $rules = null;

    #[ORM\OneToMany(mappedBy: 'creche', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->teams = new ArrayCollection();
        $this->photos = new ArrayCollection();
        $this->administrations = new ArrayCollection();
        $this->children = new ArrayCollection();
        $this->services = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): static
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getLocalisation(): ?string
    {
        return $this->localisation;
    }

    public function setLocalisation(string $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function getPostCode(): ?int
    {
        return $this->postCode;
    }

    public function setPostCode(int $postCode): static
    {
        $this->postCode = $postCode;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): static
    {
        $this->city = $city;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getInsuranceNumber(): ?string
    {
        return $this->insuranceNumber;
    }

    public function setInsuranceNumber(string $insuranceNumber): static
    {
        $this->insuranceNumber = $insuranceNumber;

        return $this;
    }

    public function getLegalStatus(): ?string
    {
        return $this->legalStatus;
    }

    public function setLegalStatus(string $legalStatus): static
    {
        $this->legalStatus = $legalStatus;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Team>
     */
    public function getTeams(): Collection
    {
        return $this->teams;
    }

    public function addTeam(Team $team): static
    {
        if (!$this->teams->contains($team)) {
            $this->teams->add($team);
            $team->setCreche($this);
        }

        return $this;
    }

    public function removeTeam(Team $team): static
    {
        if ($this->teams->removeElement($team)) {
            // set the owning side to null (unless already changed)
            if ($team->getCreche() === $this) {
                $team->setCreche(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Photo>
     */
    public function getPhotos(): Collection
    {
        return $this->photos;
    }

    public function addPhoto(Photo $photo): static
    {
        if (!$this->photos->contains($photo)) {
            $this->photos->add($photo);
            $photo->setCreche($this);
        }

        return $this;
    }

    public function removePhoto(Photo $photo): static
    {
        if ($this->photos->removeElement($photo)) {
            // set the owning side to null (unless already changed)
            if ($photo->getCreche() === $this) {
                $photo->setCreche(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Administration>
     */
    public function getAdministrations(): Collection
    {
        return $this->administrations;
    }

    public function addAdministration(Administration $administration): static
    {
        if (!$this->administrations->contains($administration)) {
            $this->administrations->add($administration);
            $administration->addCreche($this);
        }

        return $this;
    }

    public function removeAdministration(Administration $administration): static
    {
        if ($this->administrations->removeElement($administration)) {
            $administration->removeCreche($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Child>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): static
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
            $child->addCreche($this);
        }

        return $this;
    }

    public function removeChild(Child $child): static
    {
        if ($this->children->removeElement($child)) {
            $child->removeCreche($this);
        }

        return $this;
    }

    public function getSchedule(): ?Schedule
    {
        return $this->schedule;
    }

    public function setSchedule(Schedule $schedule): static
    {
        // set the owning side of the relation if necessary
        if ($schedule->getCreche() !== $this) {
            $schedule->setCreche($this);
        }

        $this->schedule = $schedule;

        return $this;
    }

    /**
     * @return Collection<int, Service>
     */
    public function getServices(): Collection
    {
        return $this->services;
    }

    public function addService(Service $service): static
    {
        if (!$this->services->contains($service)) {
            $this->services->add($service);
            $service->setCreche($this);
        }

        return $this;
    }

    public function removeService(Service $service): static
    {
        if ($this->services->removeElement($service)) {
            // set the owning side to null (unless already changed)
            if ($service->getCreche() === $this) {
                $service->setCreche(null);
            }
        }

        return $this;
    }

    public function getRules(): ?string
    {
        return $this->rules;
    }

    public function setRules(string $rules): static
    {
        $this->rules = $rules;

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
            $reservation->setCreche($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getCreche() === $this) {
                $reservation->setCreche(null);
            }
        }

        return $this;
    }
}
