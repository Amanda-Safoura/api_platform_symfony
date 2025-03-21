<?php

namespace App\Entity;

use App\Repository\AuditSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AuditSectionRepository::class)]
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

    #[ORM\ManyToOne(inversedBy: 'auditSections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Audit $audit_id = null;

    /**
     * @var Collection<int, AuditSubsection>
     */
    #[ORM\OneToMany(targetEntity: AuditSubsection::class, mappedBy: 'audit_section_id')]
    private Collection $auditSubsections;

    public function __construct()
    {
        $this->auditSubsections = new ArrayCollection();
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

    public function getAuditId(): ?Audit
    {
        return $this->audit_id;
    }

    public function setAuditId(?Audit $audit_id): static
    {
        $this->audit_id = $audit_id;

        return $this;
    }

    /**
     * @return Collection<int, AuditSubsection>
     */
    public function getAuditSubsections(): Collection
    {
        return $this->auditSubsections;
    }

    public function addAuditSubsection(AuditSubsection $auditSubsection): static
    {
        if (!$this->auditSubsections->contains($auditSubsection)) {
            $this->auditSubsections->add($auditSubsection);
            $auditSubsection->setAuditSectionId($this);
        }

        return $this;
    }

    public function removeAuditSubsection(AuditSubsection $auditSubsection): static
    {
        if ($this->auditSubsections->removeElement($auditSubsection)) {
            // set the owning side to null (unless already changed)
            if ($auditSubsection->getAuditSectionId() === $this) {
                $auditSubsection->setAuditSectionId(null);
            }
        }

        return $this;
    }
}
