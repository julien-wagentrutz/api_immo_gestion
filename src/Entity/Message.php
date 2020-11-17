<?php

namespace App\Entity;

use App\Repository\MessageRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=MessageRepository::class)
 */
class Message
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesSent")
     * @ORM\JoinColumn(nullable=false)
     */
    private $sender;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="messagesRecipient")
     */
    private $recipientUser;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="messagesRecipient")
     */
    private $recipientGroup;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->createdAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getSender(): ?User
    {
        return $this->sender;
    }

    public function setSender(?User $sender): self
    {
        $this->sender = $sender;

        return $this;
    }

    public function getRecipientUser(): ?User
    {
        return $this->recipientUser;
    }

    public function setRecipientUser(?User $recipientUser): self
    {
        $this->recipientUser = $recipientUser;

        return $this;
    }

    public function getRecipientGroup(): ?Group
    {
        return $this->recipientGroup;
    }

    public function setRecipientGroup(?Group $recipientGroup): self
    {
        $this->recipientGroup = $recipientGroup;

        return $this;
    }
}
