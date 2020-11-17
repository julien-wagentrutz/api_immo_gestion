<?php

namespace App\Entity;

use App\Repository\LodgingRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionDoctrine;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=LodgingRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Lodging
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read_lodging"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read_lodging"})
     */
    private $name;

    /**
     * @ORM\Column(type="integer", nullable=true)
     * @Groups({"public_read_lodging"})
     */
    private $price;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read_lodging","read_collection"})
     */
    private $createAt;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"read_lodging"})
     */
    private $lastUpdateAt;

    /**
     * @ORM\ManyToOne(targetEntity=LodgingType::class, inversedBy="lodgingCollection")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"public_read_lodging"})
     */
    private $lodgingType;

    /**
     * @ORM\ManyToOne(targetEntity=State::class, inversedBy="lodgings")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"public_read_lodging"})
     */
    private $state;

    /**
     * @ORM\OneToOne(targetEntity=Address::class, cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"public_read_lodging"})
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Group::class, inversedBy="lodgings")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupId;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lodgingsCreate")
     * @ORM\JoinColumn(nullable=false)
     */
    private $creator;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="lodgingsModifier")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lastModifier;

    /**
     * @ORM\OneToMany(targetEntity=Rent::class, mappedBy="lodging")
     *
     */
    private $rents;

    /**
     * @ORM\OneToMany(targetEntity=Intervention::class, mappedBy="lodging")
     */
    private $interventions;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->rents = new ArrayCollection();
        $this->interventions = new ArrayCollection();
        $this->lastUpdateAt = new \DateTime();
        $this->createAt = new \DateTime();
    }

    /**
     * @ORM\PreUpdate
     */
    public function setLastUpdate(): self
    {
        $this->lastUpdateAt = new \DateTime();

        return $this;
    }

    public function getState(): ?State
    {
        return $this->state;
    }

    public function setState(?State $state): self
    {
        $this->state = $state;

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

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(?int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreateAt(): ?\DateTimeInterface
    {
        return $this->createAt;
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

    public function getLodgingType(): ?LodgingType
    {
        return $this->lodgingType;
    }

    public function setLodgingType(?LodgingType $lodgingType): self
    {
        $this->lodgingType = $lodgingType;

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getGroupId(): ?Group
    {
        return $this->groupId;
    }

    public function setGroupId(?Group $groupId): self
    {
        $this->groupId = $groupId;

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

    /**
     * @return CollectionDoctrine|Rent[]
     */
    public function getRents(): CollectionDoctrine
    {
        return $this->rents;
    }

    public function addRent(Rent $rent): self
    {
        if (!$this->rents->contains($rent)) {
            $this->rents[] = $rent;
            $rent->setLodging($this);
        }

        return $this;
    }

    public function removeRent(Rent $rent): self
    {
        if ($this->rents->removeElement($rent)) {
            // set the owning side to null (unless already changed)
            if ($rent->getLodging() === $this) {
                $rent->setLodging(null);
            }
        }

        return $this;
    }

    /**
     * @return CollectionDoctrine|Intervention[]
     */
    public function getInterventions(): CollectionDoctrine
    {
        return $this->interventions;
    }

    public function addIntervention(Intervention $intervention): self
    {
        if (!$this->interventions->contains($intervention)) {
            $this->interventions[] = $intervention;
            $intervention->setLodging($this);
        }

        return $this;
    }

    public function removeIntervention(Intervention $intervention): self
    {
        if ($this->interventions->removeElement($intervention)) {
            // set the owning side to null (unless already changed)
            if ($intervention->getLodging() === $this) {
                $intervention->setLodging(null);
            }
        }

        return $this;
    }

    public function setCreateAt(\DateTimeInterface $createAt): self
    {
        $this->createAt = $createAt;

        return $this;
    }


}
