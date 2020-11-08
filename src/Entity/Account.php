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
     * @Groups({"read_user", "read_account","read_tenant"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Groups({"read_account"})
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
     * @Groups({"read_account"})
     */
    private $users;

    /**
     *
     * @ORM\OneToMany(targetEntity=User::class, mappedBy="lastAccountSelected")
     * @Groups({"read_account"})
     */
    private $usersLastAccount;

    /**
     * @ORM\ManyToOne(targetEntity=Collection::class, inversedBy="account")
     */
    private $collection;

    /**
     * @ORM\OneToMany(targetEntity=Collection::class, mappedBy="account", orphanRemoval=true)
     */
    private $collections;


    public function __construct()
    {
        $this->lodgingCollection = new ArrayCollection();
        $this->tenants = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->usersLastAccount = new ArrayCollection();
        $this->collections = new ArrayCollection();
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
    public function getLodgingCollection(): CollectionDoctrine
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
    public function getTenants(): CollectionDoctrine
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
    public function getUsers(): CollectionDoctrine
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
    public function getUsersLastAccount(): CollectionDoctrine
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

    public function getCollection(): ?CollectionDoctrine
    {
        return $this->collection;
    }

    public function setCollection(?CollectionDoctrine $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    /**
     * @return CollectionDoctrine|Collection[]
     */
    public function getCollections(): CollectionDoctrine
    {
        return $this->collections;
    }

    public function addCollection(Collection $collection): self
    {
        if (!$this->collections->contains($collection)) {
            $this->collections[] = $collection;
            $collection->setAccount($this);
        }

        return $this;
    }

    public function removeCollection(Collection $collection): self
    {
        if ($this->collections->removeElement($collection)) {
            // set the owning side to null (unless already changed)
            if ($collection->getAccount() === $this) {
                $collection->setAccount(null);
            }
        }

        return $this;
    }

}
