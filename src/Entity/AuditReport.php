<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuditReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

use function Symfony\Component\Clock\now;

#[ORM\Entity(repositoryClass: AuditReportRepository::class)]
#[UniqueEntity('name')]
#[ApiResource()]
class AuditReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'auditReport', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuditSubsection $audit_subsection = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Length(min: 8)
    ])]
    private ?string $report_message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $report_proof = null;

    #[ORM\Column]
    private ?bool $is_okey = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct() {
        $this->createdAt = now();
        $this->updatedAt = now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuditSubsection(): ?AuditSubsection
    {
        return $this->audit_subsection;
    }

    public function setAuditSubsection(AuditSubsection $audit_subsection): static
    {
        $this->audit_subsection = $audit_subsection;

        return $this;
    }

    public function getReportMessage(): ?string
    {
        return $this->report_message;
    }

    public function setReportMessage(?string $report_message): static
    {
        $this->report_message = $report_message;

        return $this;
    }

    public function getReportProof(): ?string
    {
        return $this->report_proof;
    }

    public function setReportProof(?string $report_proof): static
    {
        $this->report_proof = $report_proof;

        return $this;
    }

    public function isOkey(): ?bool
    {
        return $this->is_okey;
    }

    public function setIsOkey(bool $is_okey): static
    {
        $this->is_okey = $is_okey;

        return $this;
    }
    
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $this->createdAt ?? $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $this->updatedAt ?? $updatedAt;

        return $this;
    }
}
