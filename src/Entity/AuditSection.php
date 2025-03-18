<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuditSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditSectionRepository::class)]
#[ApiResource]
class AuditSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, AuditReport>
     */
    #[ORM\OneToMany(targetEntity: AuditReport::class, mappedBy: 'audit_section')]
    private Collection $auditReports;

    public function __construct()
    {
        $this->auditReports = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, AuditReport>
     */
    public function getAuditReports(): Collection
    {
        return $this->auditReports;
    }

    public function addAuditReport(AuditReport $auditReport): static
    {
        if (!$this->auditReports->contains($auditReport)) {
            $this->auditReports->add($auditReport);
            $auditReport->setAuditSection($this);
        }

        return $this;
    }

    public function removeAuditReport(AuditReport $auditReport): static
    {
        if ($this->auditReports->removeElement($auditReport)) {
            // set the owning side to null (unless already changed)
            if ($auditReport->getAuditSection() === $this) {
                $auditReport->setAuditSection(null);
            }
        }

        return $this;
    }

}
