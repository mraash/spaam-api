<?php

namespace App\Domain\Entity;

use App\Domain\Repository\FirstTestRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FirstTestRepository::class)]
class FirstTest
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $propertyStr = null;

    #[ORM\Column]
    private ?int $propertyInt = null;

    #[ORM\Column]
    private ?bool $propertyBool = null;

    public function getId(): int
    {
        /** @var int */
        return $this->id;
    }

    public function getPropertyStr(): string
    {
        /** @var string */
        return $this->propertyStr;
    }

    public function setPropertyStr(string $propertyStr): self
    {
        $this->propertyStr = $propertyStr;

        return $this;
    }

    public function getPropertyInt(): int
    {
        /** @var int */
        return $this->propertyInt;
    }

    public function setPropertyInt(int $propertyInt): self
    {
        $this->propertyInt = $propertyInt;

        return $this;
    }

    public function isPropertyBool(): bool
    {
        /** @var bool */
        return $this->propertyBool;
    }

    public function setPropertyBool(bool $propertyBool): self
    {
        $this->propertyBool = $propertyBool;

        return $this;
    }
}
