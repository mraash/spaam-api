<?php

namespace App\Domain\Entity;

use App\Domain\Entity\VkAccount;
use App\Domain\Repository\SpamPanelRepository;
use App\Http\Response\Resource\SpamPanelResource;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use SymfonyExtension\Domain\Entity\ResourceEntityInterface;

#[ORM\Entity(repositoryClass: SpamPanelRepository::class)]
class SpamPanel implements ResourceEntityInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private User $owner;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: true)]
    private ?VkAccount $sender;

    #[ORM\Column(length: 255)]
    private string $recipient;

    /** @var string[] */
    #[ORM\Column(type: Types::JSON)]
    private array $texts = [];

    /** @var array<array<string,int|null>> */
    #[ORM\Column(type: Types::JSON)]
    private array $timers = [];

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

    public function getSender(): ?VkAccount
    {
        return $this->sender;
    }

    public function setSender(?VkAccount $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    public function getRecipient(): string
    {
        return $this->recipient;
    }

    public function setRecipient(string $recipient): self
    {
        $this->recipient = $recipient;
        return $this;
    }

    /**
     * @return string[]
     */
    public function getTexts(): array
    {
        return $this->texts;
    }

    /**
     * @param string[] $texts
     */
    public function setTexts(array $texts): self
    {
        $this->texts = $texts;
        return $this;
    }

    /**
     * @return array<array<string,int|null>>
     */
    public function getTimers(): array
    {
        return $this->timers;
    }

    /**
     * @param array<array<string,int|null>> $timers
     */
    public function setTimers(array $timers): self
    {
        // todo: Add typing to $timers variable

        $this->timers = $timers;
        return $this;
    }

    public function toResource(): SpamPanelResource
    {
        return new SpamPanelResource($this);
    }
}
