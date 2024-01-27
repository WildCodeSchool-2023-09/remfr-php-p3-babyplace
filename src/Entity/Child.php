<?php

namespace App\Entity;

use App\Repository\ChildRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeInterface;
use DateTime;

#[ORM\Entity(repositoryClass: ChildRepository::class)]
#[Vich\Uploadable]
class Child
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $childFirstname = null;

    #[ORM\Column(length: 100)]
    private ?string $childLastname = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?DateTimeInterface $birthdate = null;

    #[ORM\Column]
    private ?bool $isWalking = null;

    #[ORM\Column(length: 255)]
    private ?string $allergy = null;

    #[ORM\Column]
    private ?bool $isDisabled = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $disability = null;

    #[ORM\Column(length: 255)]
    private ?string $birthCertificate = null;

    #[Vich\UploadableField(mapping: '', fileNameProperty: 'birthCertificate')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $birthCertificateFile = null;

    #[ORM\Column(length: 255)]
    private ?string $doctorName = null;

    #[ORM\Column(length: 255)]
    private ?string $vaccine = null;

    #[Vich\UploadableField(mapping: '', fileNameProperty: 'vaccine')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $vaccineFile = null;

    #[ORM\Column(length: 255)]
    private ?string $insurance = null;

    #[Vich\UploadableField(mapping: '', fileNameProperty: 'insurance')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $insuranceFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'children')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $family = null;

    #[ORM\ManyToMany(targetEntity: Creche::class, inversedBy: 'children')]
    private Collection $creche;

    #[ORM\OneToMany(mappedBy: 'child', targetEntity: Reservation::class)]
    private Collection $reservations;

    public function __construct()
    {
        $this->creche = new ArrayCollection();
        $this->reservations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getChildFirstname(): ?string
    {
        return $this->childFirstname;
    }

    public function setChildFirstname(string $childFirstname): static
    {
        $this->childFirstname = $childFirstname;

        return $this;
    }

    public function getChildLastname(): ?string
    {
        return $this->childLastname;
    }

    public function setChildLastname(string $childLastname): static
    {
        $this->childLastname = $childLastname;

        return $this;
    }

    public function getBirthdate(): ?DateTimeInterface
    {
        return $this->birthdate;
    }

    public function setBirthdate(DateTimeInterface $birthdate): static
    {
        $this->birthdate = $birthdate;

        return $this;
    }

    public function isIsWalking(): ?bool
    {
        return $this->isWalking;
    }

    public function setIsWalking(bool $isWalking): static
    {
        $this->isWalking = $isWalking;

        return $this;
    }

    public function getAllergy(): ?string
    {
        return $this->allergy;
    }

    public function setAllergy(string $allergy): static
    {
        $this->allergy = $allergy;

        return $this;
    }

    public function isIsDisabled(): ?bool
    {
        return $this->isDisabled;
    }

    public function setIsDisabled(bool $isDisabled): static
    {
        $this->isDisabled = $isDisabled;

        return $this;
    }

    public function getDisability(): ?string
    {
        return $this->disability;
    }

    public function setDisability(?string $disability): static
    {
        $this->disability = $disability;

        return $this;
    }

    public function getBirthCertificate(): ?string
    {
        return $this->birthCertificate;
    }

    public function setBirthCertificate(string $birthCertificate): static
    {
        $this->birthCertificate = $birthCertificate;

        return $this;
    }

    public function getDoctorName(): ?string
    {
        return $this->doctorName;
    }

    public function setDoctorName(string $doctorName): static
    {
        $this->doctorName = $doctorName;

        return $this;
    }

    public function getVaccine(): ?string
    {
        return $this->vaccine;
    }

    public function setVaccine(string $vaccine): static
    {
        $this->vaccine = $vaccine;

        return $this;
    }

    public function getInsurance(): ?string
    {
        return $this->insurance;
    }

    public function setInsurance(string $insurance): static
    {
        $this->insurance = $insurance;

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

    /**
     * @return Collection<int, Creche>
     */
    public function getCreche(): Collection
    {
        return $this->creche;
    }

    public function addCreche(Creche $creche): static
    {
        if (!$this->creche->contains($creche)) {
            $this->creche->add($creche);
        }

        return $this;
    }

    public function removeCreche(Creche $creche): static
    {
        $this->creche->removeElement($creche);

        return $this;
    }

    /**
     * Get the value of birthCertificateFile
     */
    public function getBirthCertificateFile(): ?File
    {
        return $this->birthCertificateFile;
    }

    /**
     * Set the value of birthCertificateFile
     *
     * @return  self
     */
    public function setBirthCertificateFile(?File $birthCertificateFile): Child
    {
        $this->birthCertificateFile = $birthCertificateFile;
        if ($birthCertificateFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of vaccineFile
     */
    public function getVaccineFile(): ?File
    {
        return $this->vaccineFile;
    }

    /**
     * Set the value of vaccineFile
     *
     * @return  self
     */
    public function setVaccineFile(?File $vaccineFile): Child
    {
        $this->vaccineFile = $vaccineFile;
        if ($vaccineFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of insuranceFile
     */
    public function getInsuranceFile(): ?File
    {
        return $this->insuranceFile;
    }

    /**
     * Set the value of insuranceFile
     *
     * @return  self
     */
    public function setInsuranceFile(?File $insuranceFile): Child
    {
        $this->insuranceFile = $insuranceFile;
        if ($insuranceFile) {
            $this->updatedAt = new DateTime('now');
        }
        return $this;
    }

    /**
     * Get the value of updatedAt
     */
    public function getUpdatedAt(): ?DatetimeInterface
    {
        return $this->updatedAt;
    }

    /**
     * Set the value of updatedAt
     *
     * @return  self
     */
    public function setUpdatedAt(?DatetimeInterface $updatedAt)
    {
        $this->updatedAt = $updatedAt;

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
            $reservation->setChild($this);
        }

        return $this;
    }

    public function removeReservation(Reservation $reservation): static
    {
        if ($this->reservations->removeElement($reservation)) {
            // set the owning side to null (unless already changed)
            if ($reservation->getChild() === $this) {
                $reservation->setChild(null);
            }
        }

        return $this;
    }
}
