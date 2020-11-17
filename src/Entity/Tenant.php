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
     * @Groups({"public_read_tenant"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read_tenant"})
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read_tenant"})
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
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdateAt;


    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $lastModifier;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="tenants")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="tenant")
     * @Groups({"public_read_tenant"})
     */
    private $rents;

    /**
     * @ORM\OneToMany(targetEntity=Intervention::class, mappedBy="tenant")
     * @Groups({"public_read_tenant"})
     */
    private $interventions;

    /**
     * @ORM\OneToOne(targetEntity=User::class, inversedBy="tenant", cascade={"persist", "remove"})
     */
    private $user;



    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->lastUpdateAt = new \DateTime();
        $this->createdAt = new \DateTime();
        $this->rents = new ArrayCollection();
        $this->interventions = new ArrayCollection();

    }

    /**
     * @ORM\PreUpdate
     */
    public function setLastUpdate(): self
    {
        $this->lastUpdateAt = new \DateTime();

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

    public function getLastModifier(): ?User
    {
        return $this->lastModifier;
    }

    public function setLastModifier(?User $lastModifier): self
    {
        $this->lastModifier = $lastModifier;

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
     * @return Collection|Rent[]
     */
    public function getRents(): Collection
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents[] = $rent;
            $rent->setTenant($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getTenant() === $this) {
                $rent->setTenant(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Intervention[]
     */
    public function getInterventions(): Collection
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions[] = $intervention;
            $intervention->setTenant($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getTenant() === $this) {
                $intervention->setTenant(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
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


}
