<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuditRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditRepository::class)]
#[ApiResource()]
class Audit
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'audits')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $company = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * @var Collection<int, AuditSection>
     */
    #[ORM\OneToMany(targetEntity: AuditSection::class, mappedBy: 'audit')]
    private Collection $auditSections;

    #[ORM\ManyToOne(inversedBy: 'audits')]
    private ?User $agent = null;

    public function __construct()
    {
        $this->auditSections = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

        return $this;
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
     * @return Collection<int, AuditSection>
     */
    public function getAuditSections(): Collection
    {
        return $this->auditSections;
    }

    public function addAuditSection(AuditSection $auditSection): static
    {
        if (!$this->auditSections->contains($auditSection)) {
            $this->auditSections->add($auditSection);
            $auditSection->setAudit($this);
        }

        return $this;
    }

    public function removeAuditSection(AuditSection $auditSection): static
    {
        if ($this->auditSections->removeElement($auditSection)) {
            // set the owning side to null (unless already changed)
            if ($auditSection->getAudit() === $this) {
                $auditSection->setAudit(null);
            }
        }

        return $this;
    }

    public function getAgent(): ?User
    {
        return $this->agent;
    }

    public function setAgent(?User $agent): static
    {
        $this->agent = $agent;

        return $this;
    }
}
