<?php

namespace App\Entity;

use App\Repository\AdministrationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Vich\UplaodableField;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\DBAL\Types\Types;
use DateTimeInterface;
use DateTime;

#[ORM\Entity(repositoryClass: AdministrationRepository::class)]
#[Vich\Uploadable]
class Administration
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $familyIncome = 'null';

    #[Vich\UploadableField(mapping: 'family_income_file', fileNameProperty:'familyIncome')]
    #[Assert\File(
        maxSize:'1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $familyIncomeFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $taxReturn = 'null';

    #[Vich\UploadableField(mapping: 'tax_return_file', fileNameProperty:'taxReturn')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $taxReturnFile = null;

    #[ORM\Column(length: 7, nullable: true)]
    #[Assert\Length(
        min: 15,
        max: 15,
        exactMessage: 'Veuillez rentrer un numéro de sécurité social de 15 caractères valide.'
    )]
    private string $cafNumber = 'null';

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Length(
        min: 15,
        max: 15,
        exactMessage: 'Veuillez rentrer un numéro de sécurité social de 15 caractères valide.'
    )]
    private string $socialNumber = 'null';

    #[ORM\Column(length: 255, nullable: true)]
    private string $residencyProof;

    #[Vich\UploadableField(mapping: 'residency_proof_file', fileNameProperty:'residencyProof')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/png', 'image/jpeg', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $residencyProofFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $statusProof = 'null';

    #[Vich\UploadableField(mapping: 'status_proof_file', fileNameProperty:'statusProof')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/png', 'image/jpeg', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $statusProofFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\Iban(
        message: 'Le numéro IBAN n\'est pas valide',
    )]
    private string $bankingInfo = 'null';

    #[ORM\Column(length: 255, nullable: true)]
    private string $discharge = 'null';

    #[Vich\UploadableField(mapping: 'discharge_file', fileNameProperty:'discharge')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $dischargeFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private string $familyRecord = 'null';

    #[Vich\UploadableField(mapping: 'family_record_file', fileNameProperty:'familyRecord')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $familyRecordFile = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $divorceDecree = null;

    #[Vich\UploadableField(mapping: 'divorce_decree_file', fileNameProperty:'divorceDecree')]
    #[Assert\File(
        maxSize: '1M',
        maxSizeMessage: 'La taille du fichier ne
         doit pas dépasser 1Mo.',
        mimeTypes: ['image/jpeg', 'image/png', 'application/pdf'],
        mimeTypesMessage: 'Veuillez insérer un fichier en format jpeg,
         png ou un fichier pdf.'
    )]
    private ?File $divorceDecreeFile = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?DatetimeInterface $updatedAt = null;

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

    public function getFamilyIncomeFile(): ?File
    {
        return $this->familyIncomeFile;
    }

    public function setFamilyIncomeFile(File $image = null): Administration
    {
        $this-> familyIncomeFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

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

    public function getTaxReturnFile(): ?File
    {
        return $this->taxReturnFile;
    }

    public function setTaxReturnFile(File $image = null): Administration
    {
        $this-> taxReturnFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

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

    public function getResidencyProofFile(): ?File
    {
        return $this->residencyProofFile;
    }

    public function setResidencyProofFile(File $image = null): Administration
    {
        $this-> residencyProofFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

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

    public function getStatusProofFile(): ?File
    {
        return $this->statusProofFile;
    }

    public function setStatusProofFile(File $image = null): Administration
    {
        $this-> statusProofFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

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

    public function setDischarge(string $discharge): self
    {
        $this->discharge = $discharge;

        return $this;
    }

    public function getDischargeFile(): ?File
    {
        return $this->dischargeFile;
    }

    public function setDischargeFile(File $image = null): Administration
    {
        $this-> dischargeFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

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

    public function getFamilyRecordFile(): ?File
    {
        return $this->familyRecordFile;
    }

    public function setFamilyRecordFile(File $image = null): Administration
    {
        $this-> familyRecordFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

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

    public function getDivorceDecreeFile(): ?File
    {
        return $this->divorceDecreeFile;
    }

    public function setDivorceDecreeFile(File $image = null): Administration
    {
        $this-> divorceDecreeFile = $image;
        if ($image) {
            $this->updatedAt = new DateTime('now');
        }

        return $this;
    }

    /*public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }*/

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
