<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Groups({"public_read"})
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     * @Groups({"private_read_user"})
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"public_read"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     * @Groups({"public_read"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"private_read_user"})
     */
    private $createdAt;

     /**
      * @ORM\Column(type="string", unique=true)
      * @Groups({"private_read_user"})
      */
     private $apiToken;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="creator")
     * @Groups({"private_read_user"})
     */
    private $lodgingsCreate;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="lastModifier")
     */
    private $lodgingsModifier;

    /**
     * @ORM\OneToMany(targetEntity=Account::class, mappedBy="creator")
     * @Groups({"private_read_user"})
     */
    private $accounts;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @Groups({"public_read"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="userSender")
     */
    private $invitationsSent;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="userRecipient", orphanRemoval=true)
     * @Groups({"private_read_user"})
     */
    private $invitationsReceived;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="sender")
     * @Groups({"private_read_user"})
     */
    private $messagesSent;

    /**
     * @ORM\OneToMany(targetEntity=Message::class, mappedBy="recipientUser")
     * @Groups({"private_read_user"})
     */
    private $messagesRecipient;

    /**
     * @ORM\OneToOne(targetEntity=Tenant::class, mappedBy="user", cascade={"persist", "remove"});
     * @Groups({"private_read_user"})
     */
    private $tenant;

    /**
     * @ORM\Column(type="string", length=10)
     * @Groups({"private_read_user"})
     */
    private $themeUse;



    public function __construct()
    {
        $this->themeUse = 'white';
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $uuid = Uuid::v4();;
        $this->apiToken = $uuid->jsonSerialize();
        $this->createdAt = new \DateTime();
        $this->accounts = new ArrayCollection();
        $this->invitationsSent = new ArrayCollection();
        $this->invitationsReceived = new ArrayCollection();
        $this->messagesSent = new ArrayCollection();
        $this->messagesRecipient = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->lodgingsCreate = new ArrayCollection();
        $this->lodgingsModifier = new ArrayCollection();
    }


    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): self
    {
        $this->tenant = $tenant;

        // set (or unset) the owning side of the relation if necessary
        $newUser = null === $tenant ? null : $this;
        if ($tenant->getUser() !== $newUser) {
            $tenant->setUser($newUser);
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

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

    public function getApiToken(): ?string
    {
        return $this->apiToken;
    }

    public function setApiToken(string $apiToken): self
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getLodgingsCreate(): Collection
    {
        return $this->lodgingsCreate;
    }

    public function addLodgingsCreate(Lodging $lodgingsCreate): self
    {
        if (!$this->lodgingsCreate->contains($lodgingsCreate)) {
            $this->lodgingsCreate[] = $lodgingsCreate;
            $lodgingsCreate->setCreator($this);
        }

        return $this;
    }

    public function removeLodgingsCreate(Lodging $lodgingsCreate): self
    {
        if ($this->lodgingsCreate->removeElement($lodgingsCreate)) {
            // set the owning side to null (unless already changed)
            if ($lodgingsCreate->getCreator() === $this) {
                $lodgingsCreate->setCreator(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getLodgingsModifier(): Collection
    {
        return $this->lodgingsModifier;
    }

    public function addLodgingsModifier(Lodging $lodgingsModifier): self
    {
        if (!$this->lodgingsModifier->contains($lodgingsModifier)) {
            $this->lodgingsModifier[] = $lodgingsModifier;
            $lodgingsModifier->setLastModifier($this);
        }

        return $this;
    }

    public function removeLodgingsModifier(Lodging $lodgingsModifier): self
    {
        if ($this->lodgingsModifier->removeElement($lodgingsModifier)) {
            // set the owning side to null (unless already changed)
            if ($lodgingsModifier->getLastModifier() === $this) {
                $lodgingsModifier->setLastModifier(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
            $account->setCreator($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->removeElement($account)) {
            // set the owning side to null (unless already changed)
            if ($account->getCreator() === $this) {
                $account->setCreator(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(?Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitationsSent(): Collection
    {
        return $this->invitationsSent;
    }

    public function addInvitationsSent(Invitation $invitationsSent): self
    {
        if (!$this->invitationsSent->contains($invitationsSent)) {
            $this->invitationsSent[] = $invitationsSent;
            $invitationsSent->setUserSender($this);
        }

        return $this;
    }

    public function removeInvitationsSent(Invitation $invitationsSent): self
    {
        if ($this->invitationsSent->removeElement($invitationsSent)) {
            // set the owning side to null (unless already changed)
            if ($invitationsSent->getUserSender() === $this) {
                $invitationsSent->setUserSender(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Invitation[]
     */
    public function getInvitationsReceived(): Collection
    {
        return $this->invitationsReceived;
    }

    public function addInvitationsReceived(Invitation $invitationsReceived): self
    {
        if (!$this->invitationsReceived->contains($invitationsReceived)) {
            $this->invitationsReceived[] = $invitationsReceived;
            $invitationsReceived->setUserRecipient($this);
        }

        return $this;
    }

    public function removeInvitationsReceived(Invitation $invitationsReceived): self
    {
        if ($this->invitationsReceived->removeElement($invitationsReceived)) {
            // set the owning side to null (unless already changed)
            if ($invitationsReceived->getUserRecipient() === $this) {
                $invitationsReceived->setUserRecipient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Message[]
     */
    public function getMessagesSent(): Collection
    {
        return $this->messagesSent;
    }

    public function addMessagesSent(Message $messagesSent): self
    {
        if (!$this->messagesSent->contains($messagesSent)) {
            $this->messagesSent[] = $messagesSent;
            $messagesSent->setSender($this);
        }

        return $this;
    }

    public function removeMessagesSent(Message $messagesSent): self
    {
        if ($this->messagesSent->removeElement($messagesSent)) {
            // set the owning side to null (unless already changed)
            if ($messagesSent->getSender() === $this) {
                $messagesSent->setSender(null);
            }
        }

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
            $messagesRecipient->setRecipientUser($this);
        }

        return $this;
    }

    public function removeMessagesRecipient(Message $messagesRecipient): self
    {
        if ($this->messagesRecipient->removeElement($messagesRecipient)) {
            // set the owning side to null (unless already changed)
            if ($messagesRecipient->getRecipientUser() === $this) {
                $messagesRecipient->setRecipientUser(null);
            }
        }

        return $this;
    }

    public function getThemeUse(): ?string
    {
        return $this->themeUse;
    }

    public function setThemeUse(string $themeUse): self
    {
        $this->themeUse = $themeUse;

        return $this;
    }

    public function equals(User $user):bool
    {
        if($this->getId() == $user->getId()) {return true;}
        return false;
    }

    public function userIsIn($invitations):bool
    {
        $isIn = false;
        $i = 0;

        while (!$isIn && $i < sizeof($invitations))
        {
            if($this->getId() == $invitations[$i]->getUserRecipient()->getId()) {$isIn = true;}
            $i++;
        }

        return $isIn;
    }

}
