<?php

namespace App\Domain\Entity;

use App\Domain\Entity\User;
use App\Domain\Repository\VkAccountRepository;
use App\Http\Response\Resource\VkAccountResource;
use Doctrine\ORM\Mapping as ORM;
use SymfonyExtension\Domain\Entity\ResourceEntityInterface;

#[ORM\Entity(repositoryClass: VkAccountRepository::class)]
class VkAccount implements ResourceEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'vkAccounts')]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    #[ORM\Column]
    private int $vkId;

    #[ORM\Column]
    private string $vkAccessToken;

    #[ORM\Column(length: 255)]
    private string $vkSlug;

    #[ORM\Column(length: 255)]
    private string $vkFullName;

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

    public function getVkSlug(): string
    {
        return $this->vkSlug;
    }

    public function setVkSlug(string $vkSlug): self
    {
        $this->vkSlug = $vkSlug;

        return $this;
    }

    public function getVkFullName(): string
    {
        return $this->vkFullName;
    }

    public function setVkFullName(string $vkFullName): self
    {
        $this->vkFullName = $vkFullName;

        return $this;
    }

    public function toResource(): VkAccountResource
    {
        return new VkAccountResource($this);
    }
}
