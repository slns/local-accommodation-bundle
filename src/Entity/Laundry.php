<?php

namespace LocalAccommodationBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: "LocalAccommodationBundle\\Repository\\LaundryRepository")]

#[ORM\HasLifecycleCallbacks]
class Laundry
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: "integer")]
    private $id;

    #[ORM\Column(type: "string", length: 255)]
    private $item;

    #[ORM\Column(type: "datetime")]
    private $deliveredAt;

    #[ORM\Column(type: "datetime", nullable: true)]
    private $receivedAt;

    #[ORM\Column(type: "datetime_immutable", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: "datetime_immutable", nullable: true, options: ["default" => "CURRENT_TIMESTAMP"])]
    private ?\DateTimeImmutable $updatedAt = null;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PrePersist]
    public function onPrePersist(): void
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->updatedAt = new \DateTimeImmutable();
    }

    #[ORM\PreUpdate]
    public function onPreUpdate(): void
    {
        $this->updatedAt = new \DateTimeImmutable();
    }

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getItem(): ?string
    {
        return $this->item;
    }
    public function setItem(string $item): self
    {
        $this->item = $item;
        return $this;
    }
    public function getDeliveredAt(): ?\DateTimeInterface
    {
        return $this->deliveredAt;
    }
    public function setDeliveredAt(\DateTimeInterface $deliveredAt): self
    {
        $this->deliveredAt = $deliveredAt;
        return $this;
    }
    public function getReceivedAt(): ?\DateTimeInterface
    {
        return $this->receivedAt;
    }
    public function setReceivedAt(?\DateTimeInterface $receivedAt): self
    {
        $this->receivedAt = $receivedAt;
        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }
}
