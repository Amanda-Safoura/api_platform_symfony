<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuditSubsectionRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AuditSubsectionRepository::class)]
#[UniqueEntity('name')]
#[ApiResource()]
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
    private ?AuditSection $audit_section = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToOne(mappedBy: 'audit_subsection', cascade: ['persist', 'remove'])]
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

    public function getAuditSection(): ?AuditSection
    {
        return $this->audit_section;
    }

    public function setAuditSection(?AuditSection $audit_section): static
    {
        $this->audit_section = $audit_section;

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

    public function getAuditReport(): ?AuditReport
    {
        return $this->auditReport;
    }

    public function setAuditReport(AuditReport $auditReport): static
    {
        // set the owning side of the relation if necessary
        if ($auditReport->getAuditSubsection() !== $this) {
            $auditReport->setAuditSubsection($this);
        }

        $this->auditReport = $auditReport;

        return $this;
    }
}
