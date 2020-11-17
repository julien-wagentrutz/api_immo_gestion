<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionDoctrine;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read_account"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"public_read_account"})
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="accounts")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"private_read_account"})
     */
    private $creator;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @Groups({"public_read_account"})
     */
    private $address;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="account", orphanRemoval=true)
     * @Groups({"private_read_account"})
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity=Invitation::class, mappedBy="account", orphanRemoval=true)
     * @Groups({"private_read_account"})
     */
    private $invitations;

    /**
     * @ORM\OneToMany(targetEntity=Tenant::class, mappedBy="account")
     * @Groups({"private_read_account"})
     */
    private $tenants;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->groups = new ArrayCollection();
        $this->invitations = new ArrayCollection();
        $this->tenants = new ArrayCollection();
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCreator(): ?User
    {
        return $this->creator;
    }

    public function setCreator(?User $creator): self
    {
        $this->creator = $creator;

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
     * @return CollectionDoctrine|Group[]
     */
    public function getGroups(): CollectionDoctrine
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setAccount($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getAccount() === $this) {
                $group->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return CollectionDoctrine|Invitation[]
     */
    public function getInvitations(): CollectionDoctrine
    {
        return $this->invitations;
    }

    public function addInvitation(Invitation $invitation): self
    {
        if (!$this->invitations->contains($invitation)) {
            $this->invitations[] = $invitation;
            $invitation->setAccount($this);
        }

        return $this;
    }

    public function removeInvitation(Invitation $invitation): self
    {
        if ($this->invitations->removeElement($invitation)) {
            // set the owning side to null (unless already changed)
            if ($invitation->getAccount() === $this) {
                $invitation->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return CollectionDoctrine|Tenant[]
     */
    public function getTenants(): CollectionDoctrine
    {
        return $this->tenants;
    }

    public function addTenant(Tenant $tenant): self
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants[] = $tenant;
            $tenant->setAccount($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        if ($this->tenants->removeElement($tenant)) {
            // set the owning side to null (unless already changed)
            if ($tenant->getAccount() === $this) {
                $tenant->setAccount(null);
            }
        }

        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

}
