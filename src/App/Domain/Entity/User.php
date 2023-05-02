<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\Repository\UserRepository;
use App\Http\Response\Resource\UserResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use SymfonyExtension\Domain\Entity\ResourceEntityInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface, ResourceEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\Column(length: 180, unique: true)]
    private string $email;

    #[ORM\Column]
    private string $password;

    /** @var string[] */
    #[ORM\Column]
    private array $roles = [];

    /** @var Collection<int,VkAccount> */
    #[ORM\OneToMany(mappedBy: 'owner', targetEntity: VkAccount::class, orphanRemoval: true)]
    private Collection $vkAccounts;

    public function __construct()
    {
        $this->vkAccounts = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUserIdentifier(): string
    {
        return $this->email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;
        return $this;
    }

    /**
     * @return Collection<int, VkAccount>
     */
    public function getVkAccounts(): Collection
    {
        return $this->vkAccounts;
    }

    public function addVkAccount(VkAccount $vkAccount): self
    {
        if (!$this->vkAccounts->contains($vkAccount)) {
            $this->vkAccounts->add($vkAccount);
            $vkAccount->setOwner($this);
        }

        return $this;
    }

    public function removeVkAccount(VkAccount $vkAccount): self
    {
        if ($this->vkAccounts->contains($vkAccount)) {
            $this->vkAccounts->removeElement($vkAccount);
        }

        return $this;
    }

    public function toResource(): UserResource
    {
        return new UserResource($this);
    }
}
