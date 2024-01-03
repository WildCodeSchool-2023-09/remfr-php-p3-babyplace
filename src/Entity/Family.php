<?php

namespace App\Entity;

use App\Repository\FamilyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: FamilyRepository::class)]
class Family
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $lastname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $firstname;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $address;

    #[ORM\Column(length: 5)]
    #[Assert\NotBlank]
    private string $postalCode;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    private string $city;

    #[ORM\Column(length: 10)]
    #[Assert\NotBlank]
    private string $phone;

    #[ORM\OneToOne(mappedBy: 'parent', cascade: ['persist', 'remove'])]
    private ?Administration $administration = null;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: Child::class, orphanRemoval: true)]
    private Collection $children;

    #[ORM\OneToMany(mappedBy: 'family', targetEntity: EmergencyContact::class, orphanRemoval: true)]
    private Collection $emergencyContacts;

    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->emergencyContacts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): static
    {
        $this->address = $address;

        return $this;
    }

    public function getPostalCode(): ?string
    {
        return $this->postalCode;
    }

    public function setPostalCode(string $postalCode): static
    {
        $this->postalCode = $postalCode;

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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getAdministration(): ?Administration
    {
        return $this->administration;
    }

    public function setAdministration(Administration $administration): static
    {
        // set the owning side of the relation if necessary
        if ($administration->getParent() !== $this) {
            $administration->setParent($this);
        }

        $this->administration = $administration;

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
            $child->setFamily($this);
        }

        return $this;
    }

    public function removeChild(Child $child): static
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getFamily() === $this) {
                $child->setFamily(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, EmergencyContact>
     */
    public function getEmergencyContacts(): Collection
    {
        return $this->emergencyContacts;
    }

    public function addEmergencyContact(EmergencyContact $emergencyContact): static
    {
        if (!$this->emergencyContacts->contains($emergencyContact)) {
            $this->emergencyContacts->add($emergencyContact);
            $emergencyContact->setFamily($this);
        }

        return $this;
    }

    public function removeEmergencyContact(EmergencyContact $emergencyContact): static
    {
        if ($this->emergencyContacts->removeElement($emergencyContact)) {
            // set the owning side to null (unless already changed)
            if ($emergencyContact->getFamily() === $this) {
                $emergencyContact->setFamily(null);
            }
        }

        return $this;
    }
}
