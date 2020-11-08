<?php

namespace App\Entity;

use App\Repository\TenantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;


/**
 * @ORM\Entity(repositoryClass=TenantRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Tenant
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"read_user", "read_lodging", "read_collection","read_tenant"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_tenant"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_tenant"})
     */
    private $lastName;

    /**
     * @ORM\Column(type="date")
     * @Groups({"read_tenant"})
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=12)
     * @Groups({"read_tenant"})
     */
    private $phoneNumber;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"read_tenant"})
     */
    private $email;

    /**
     * @ORM\ManyToMany(targetEntity=Account::class, mappedBy="tenants")
     * @Groups({"read_tenant"})
     */
    private $accounts;

    /**
     * @ORM\ManyToMany(targetEntity=Lodging::class, inversedBy="tenants")
     * @Groups({"read_tenant"})
     */
    private $lodgingCollection;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="tenantsModify")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"read_tenant"})
     */
    private $nameLastModifier;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdateAt;



    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->lodgingCollection = new ArrayCollection();
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
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
            $account->addTenant($this);
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        if ($this->accounts->removeElement($account)) {
            $account->removeTenant($this);
        }

        return $this;
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
        }

        return $this;
    }

    public function removeLodgingCollection(Lodging $lodgingCollection): self
    {
        $this->lodgingCollection->removeElement($lodgingCollection);

        return $this;
    }


    public function getNameLastModifier(): ?User
    {
        return $this->nameLastModifier;
    }

    public function setNameLastModifier(?User $user): self
    {
        $this->nameLastModifier = $user;

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

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    public function setLastUpdateAt(\DateTimeInterface $lastUpdateAt): self
    {
        $this->lastUpdateAt = $lastUpdateAt;

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
     * @ORM\PreUpdate
     */
    public function setLastUpdate(): self
    {
        $this->lastUpdateAt = new \DateTime();

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setUpLastUpdate(): self
    {
        $this->lastUpdateAt = new \DateTime();

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreateAt(): self
    {
        $this->createdAt = new \DateTime();

        return $this;
    }

}
