<?php

namespace App\Entity;

use App\Repository\LodgingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionDoctrine;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=LodgingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Lodging
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $state;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $zipCode;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $address;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $complementAddress;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $lastUpdateAt;

    /**
     * @ORM\ManyToOne(targetEntity=LodgingType::class, inversedBy="lodgingCollection")
     */
    private $lodgingType;

    /**
     * @ORM\ManyToOne(targetEntity=Collection::class, inversedBy="lodgingItems")
     */
    private $collection;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="lodgingCollection")
     * @ORM\JoinColumn(nullable=false)
     */
    private $account;

    /**
     * @ORM\ManyToMany(targetEntity=Tenant::class, mappedBy="lodgingCollection")
     */
    private $tenants;

    public function __construct()
    {
        $this->tenants = new ArrayCollection();
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

    public function getState(): ?string
    {
        return $this->state;
    }

    public function setState(string $state): self
    {
        $this->state = $state;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getZipCode(): ?string
    {
        return $this->zipCode;
    }

    public function setZipCode(?string $zipCode): self
    {
        $this->zipCode = $zipCode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getComplementAddress(): ?string
    {
        return $this->complementAddress;
    }

    public function setComplementAddress(?string $complementAddress): self
    {
        $this->complementAddress = $complementAddress;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreateAt(): self
    {
        $this->createAt = new \DateTime();

        return $this;
    }

    public function getLastUpdateAt(): ?\DateTimeInterface
    {
        return $this->lastUpdateAt;
    }

    /**
     * @ORM\PreUpdate
     */
    public function setLastUpdate(): self
    {
        $this->createAt = new \DateTime();

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
    public function setIdValue()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
    }

    public function getLodgingType(): ?LodgingType
    {
        return $this->lodgingType;
    }

    public function setLodgingType(?LodgingType $lodgingType): self
    {
        $this->lodgingType = $lodgingType;

        return $this;
    }

    public function getCollection(): ?Collection
    {
        return $this->collection;
    }

    public function setCollection(?Collection $collection): self
    {
        $this->collection = $collection;

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
            $tenant->addLodgingCollection($this);
        }

        return $this;
    }

    public function removeTenant(Tenant $tenant): self
    {
        if ($this->tenants->removeElement($tenant)) {
            $tenant->removeLodgingCollection($this);
        }

        return $this;
    }

}
