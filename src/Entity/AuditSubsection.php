<?php

namespace App\Entity;

use App\Repository\AuditSubsectionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditSubsectionRepository::class)]
class AuditSubsection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'auditSubsections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?AuditSection $audit_section_id = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'audit_subsection_id', cascade: ['persist', 'remove'])]
    private ?AuditReport $auditReport = null;

    public function getId(): ?int
    {
        return $this->id;
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

    public function getAuditSectionId(): ?AuditSection
    {
        return $this->audit_section_id;
    }

    public function setAuditSectionId(?AuditSection $audit_section_id): static
    {
        $this->audit_section_id = $audit_section_id;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getAuditReport(): ?AuditReport
    {
        return $this->auditReport;
    }

    public function setAuditReport(AuditReport $auditReport): static
    {
        // set the owning side of the relation if necessary
        if ($auditReport->getAuditSubsectionId() !== $this) {
            $auditReport->setAuditSubsectionId($this);
        }

        $this->auditReport = $auditReport;

        return $this;
    }
}
