<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read"})
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=GroupType::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"public_read"})
     */
    private $groupType;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="groupId", orphanRemoval=true)
     * @Groups({"public_read"})
     */
    private $lodgings;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="recipientGroup")
     */
    private $messagesRecipient;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->lodgings = new ArrayCollection();
        $this->messagesRecipient = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGroupType(): ?GroupType
    {
        return $this->groupType;
    }

    public function setGroupType(?GroupType $groupType): self
    {
        $this->groupType = $groupType;

        return $this;
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getLodgings(): Collection
    {
        return $this->lodgings;
    }

    public function addLodging(Lodging $lodging): self
    {
        if (!$this->lodgings->contains($lodging)) {
            $this->lodgings[] = $lodging;
            $lodging->setGroupId($this);
        }

        return $this;
    }

    public function removeLodging(Lodging $lodging): self
    {
        if ($this->lodgings->removeElement($lodging)) {
            // set the owning side to null (unless already changed)
            if ($lodging->getGroupId() === $this) {
                $lodging->setGroupId(null);
            }
        }

        return $this;
    }

    public function getAccount(): ?Account
    {
        return $this->account;
    }

    public function setAccount(?Account $account): self
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesRecipient(): Collection
    {
        return $this->messagesRecipient;
    }

    public function addMessagesRecipient(Message $messagesRecipient): self
    {
        if (!$this->messagesRecipient->contains($messagesRecipient)) {
            $this->messagesRecipient[] = $messagesRecipient;
            $messagesRecipient->setRecipientGroup($this);
        }

        return $this;
    }

    public function removeMessagesRecipient(Message $messagesRecipient): self
    {
        if ($this->messagesRecipient->removeElement($messagesRecipient)) {
            // set the owning side to null (unless already changed)
            if ($messagesRecipient->getRecipientGroup() === $this) {
                $messagesRecipient->setRecipientGroup(null);
            }
        }

        return $this;
    }
}
