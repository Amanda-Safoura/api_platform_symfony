<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuditReportRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditReportRepository::class)]
#[ApiResource]
class AuditReport
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'auditReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuditSection $audit_section = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $report_message = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $report_proof = null;

    #[ORM\Column]
    private ?bool $is_okey = null;

    #[ORM\ManyToOne(inversedBy: 'auditReports')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Audit $audit = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuditSection(): ?AuditSection
    {
        return $this->audit_section;
    }

    public function setAuditSection(?AuditSection $audit_section): static
    {
        $this->audit_section = $audit_section;

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

    public function getAudit(): ?Audit
    {
        return $this->audit;
    }

    public function setAudit(?Audit $audit): static
    {
        $this->audit = $audit;

        return $this;
    }
}
