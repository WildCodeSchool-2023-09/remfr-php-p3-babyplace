<?php

namespace App\Entity;

use App\Repository\AdministrationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AdministrationRepository::class)]
class Administration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $familyIncome = null;

    #[ORM\Column(length: 255)]
    private ?string $taxReturn = null;

    #[ORM\Column(length: 7)]
    private ?string $cafNumber = null;

    #[ORM\Column(length: 15)]
    private ?string $socialNumber = null;

    #[ORM\Column(length: 255)]
    private ?string $residencyProof = null;

    #[ORM\Column(length: 255)]
    private ?string $statusProof = null;

    #[ORM\Column(length: 255)]
    private ?string $bankingInfo = null;

    #[ORM\Column(length: 255)]
    private ?string $discharge = null;

    #[ORM\Column(length: 255)]
    private ?string $familyRecord = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $divorceDecree;

    #[ORM\OneToOne(inversedBy: 'administration', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Family $parent = null;

    #[ORM\ManyToMany(targetEntity: Creche::class, inversedBy: 'administrations')]
    private Collection $creche;

    public function __construct()
    {
        $this->creche = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFamilyIncome(): ?string
    {
        return $this->familyIncome;
    }

    public function setFamilyIncome(string $familyIncome): static
    {
        $this->familyIncome = $familyIncome;

        return $this;
    }

    public function getTaxReturn(): ?string
    {
        return $this->taxReturn;
    }

    public function setTaxReturn(string $taxReturn): static
    {
        $this->taxReturn = $taxReturn;

        return $this;
    }

    public function getCafNumber(): ?string
    {
        return $this->cafNumber;
    }

    public function setCafNumber(string $cafNumber): static
    {
        $this->cafNumber = $cafNumber;

        return $this;
    }

    public function getSocialNumber(): ?string
    {
        return $this->socialNumber;
    }

    public function setSocialNumber(string $socialNumber): static
    {
        $this->socialNumber = $socialNumber;

        return $this;
    }

    public function getResidencyProof(): ?string
    {
        return $this->residencyProof;
    }

    public function setResidencyProof(string $residencyProof): static
    {
        $this->residencyProof = $residencyProof;

        return $this;
    }

    public function getStatusProof(): ?string
    {
        return $this->statusProof;
    }

    public function setStatusProof(string $statusProof): static
    {
        $this->statusProof = $statusProof;

        return $this;
    }

    public function getBankingInfo(): ?string
    {
        return $this->bankingInfo;
    }

    public function setBankingInfo(string $bankingInfo): static
    {
        $this->bankingInfo = $bankingInfo;

        return $this;
    }

    public function getDischarge(): ?string
    {
        return $this->discharge;
    }

    public function setDischarge(string $discharge): static
    {
        $this->discharge = $discharge;

        return $this;
    }

    public function getFamilyRecord(): ?string
    {
        return $this->familyRecord;
    }

    public function setFamilyRecord(string $familyRecord): static
    {
        $this->familyRecord = $familyRecord;

        return $this;
    }

    public function getDivorceDecree(): ?string
    {
        return $this->divorceDecree;
    }

    public function setDivorceDecree(string $divorceDecree): static
    {
        $this->divorceDecree = $divorceDecree;

        return $this;
    }

    public function getParent(): ?Family
    {
        return $this->parent;
    }

    public function setParent(Family $parent): static
    {
        $this->parent = $parent;

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
}
