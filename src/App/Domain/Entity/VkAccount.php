<?php

namespace App\Domain\Entity;

use App\Domain\Entity\User;
use App\Domain\Repository\VkAccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VkAccountRepository::class)]
class VkAccount
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id; /** @phpstan-ignore-line */

    #[ORM\ManyToOne(inversedBy: 'vkAccounts')]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    #[ORM\Column]
    private int $vkId;

    #[ORM\Column]
    private string $vkAccessToken;

    public function getId(): int
    {
        return $this->id;
    }

    public function getOwner(): User
    {
        return $this->owner;
    }

    public function setOwner(User $owner): self
    {
        $this->owner = $owner;
        return $this;
    }

    public function getVkId(): int
    {
        return $this->vkId;
    }

    public function setVkId(int $vkId): self
    {
        $this->vkId = $vkId;
        return $this;
    }

    public function getVkAccessToken(): string
    {
        return $this->vkAccessToken;
    }

    public function setVkAccessToken(string $vkAccessToken): self
    {
        $this->vkAccessToken = $vkAccessToken;
        return $this;
    }
}
