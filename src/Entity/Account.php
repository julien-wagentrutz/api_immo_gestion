<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=AccountRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Account
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $state;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="account", orphanRemoval=true)
     */
    private $lodgingCollection;

    /**
     * @ORM\ManyToMany(targetEntity=Tenant::class, inversedBy="accounts")
     */
    private $tenants;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="accounts")
     */
    private $users;

    /**
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="lastAccountSelected")
     */
    private $usersLastAccount;


    public function __construct()
    {
        $this->lodgingCollection = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->usersLastAccount = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setIdValue()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getLodgingCollection(): Collection
    {
        return $this->lodgingCollection;
    }

    public function addLodgingCollection(Lodging $lodgingCollection): self
    {
        if (!$this->lodgingCollection->contains($lodgingCollection)) {
            $this->lodgingCollection[] = $lodgingCollection;
            $lodgingCollection->setAccount($this);
        }

        return $this;
    }

    public function removeLodgingCollection(Lodging $lodgingCollection): self
    {
        if ($this->lodgingCollection->removeElement($lodgingCollection)) {
            // set the owning side to null (unless already changed)
            if ($lodgingCollection->getAccount() === $this) {
                $lodgingCollection->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Tenant[]
     */
    public function getTenants(): Collection
    {
        return $this->tenants;
    }

    public function addTenant(Tenant $tenant): self
    {
        if (!$this->tenants->contains($tenant)) {
            $this->tenants[] = $tenant;
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        $this->tenants->removeElement($tenant);

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addAccount($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeAccount($this);
        }

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsersLastAccount(): Collection
    {
        return $this->usersLastAccount;
    }

    public function addUsersLastAccount(User $usersLastAccount): self
    {
        if (!$this->usersLastAccount->contains($usersLastAccount)) {
            $this->usersLastAccount[] = $usersLastAccount;
            $usersLastAccount->setLastAccountSelected($this);
        }

        return $this;
    }

    public function removeUsersLastAccount(User $usersLastAccount): self
    {
        if ($this->usersLastAccount->removeElement($usersLastAccount)) {
            // set the owning side to null (unless already changed)
            if ($usersLastAccount->getLastAccountSelected() === $this) {
                $usersLastAccount->setLastAccountSelected(null);
            }
        }

        return $this;
    }

}
