<?php

namespace App\Entity;

use App\Repository\AuditReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditReportRepository::class)]
class AuditReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'auditReport', cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuditSubsection $audit_subsection_id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $report_message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $report_proof = null;

    #[ORM\Column]
    private ?bool $is_okey = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuditSubsectionId(): ?AuditSubsection
    {
        return $this->audit_subsection_id;
    }

    public function setAuditSubsectionId(AuditSubsection $audit_subsection_id): static
    {
        $this->audit_subsection_id = $audit_subsection_id;

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
}
