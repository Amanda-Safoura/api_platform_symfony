<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Patch;
use ApiPlatform\Metadata\Put;
use App\Controller\RetrieveCurrentUserInfosController;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

use function Symfony\Component\Clock\now;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_USERNAME', fields: ['username'])]
#[ApiResource(
    security: "is_granted('ROLE_ADMIN')",
    securityMessage: "You're not allowed to access this methods",
    operations: [
        new Get(
            name: 'retrieve me',
            uriTemplate: '/users/me',
            controller: RetrieveCurrentUserInfosController::class,
            read: false,
            description: 'Retrieve current user info',
            security: "is_granted('ROLE_USER')"
        ),
        new Get(),
        new GetCollection(
            normalizationContext: ['groups' => ['read:User:Collection']]
        ),
        new Post(),
        new Put(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['read:item']],
    denormalizationContext: ['groups' => ['write:User:item']]
)]

class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['read:User:Collection'])]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    #[Groups(['read:item', 'write:User:item', 'read:User:Collection'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Length(min: 3, max: 180),
    ])]
    private ?string $username = null;

    /**
     * @var list<string> The user roles
     */
    #[ORM\Column]
    #[Groups(['write:User:item'])]
    #[Assert\Choice(choices: ['ROLE_USER', 'ROLE_ADMIN'], multiple: true)]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    #[Groups(['write:User:item'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Type('string'),
        new Assert\PasswordStrength(minScore: PasswordStrength::STRENGTH_WEAK)
    ])]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    #[Groups(['read:item', 'write:User:item', 'read:User:Collection'])]
    #[Assert\Sequentially([
        new Assert\NotBlank(),
        new Assert\Email()
    ])]
    private ?string $email = null;

    /**
     * @var Collection<int, Audit>
     */
    #[ORM\OneToMany(targetEntity: Audit::class, mappedBy: 'agent')]
    #[Groups(['read:item', 'read:User:Collection'])]
    private Collection $audits;

    #[ORM\Column]
    #[Assert\DateTime(format: 'Y-m-d H:i:s', message: 'Le format de la date doit être comme suit: 2020-12-31 17:24:45')]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\DateTime(format: 'Y-m-d H:i:s')]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->audits = new ArrayCollection();
        $this->createdAt = now();
        $this->updatedAt = now();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     * @return list<string>
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * @param list<string> $roles
     */
    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Audit>
     */
    public function getAudits(): Collection
    {
        return $this->audits;
    }

    public function addAudit(Audit $audit): static
    {
        if (!$this->audits->contains($audit)) {
            $this->audits->add($audit);
            $audit->setAgent($this);
        }

        return $this;
    }

    public function removeAudit(Audit $audit): static
    {
        if ($this->audits->removeElement($audit)) {
            // set the owning side to null (unless already changed)
            if ($audit->getAgent() === $this) {
                $audit->setAgent(null);
            }
        }

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
