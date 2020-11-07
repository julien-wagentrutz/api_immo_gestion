<?php

namespace App\Entity;

use App\Repository\LodgingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=LodgingTypeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class LodgingType
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=LodgingCategory::class, inversedBy="types")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lodgingCategory;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="lodgingType")
     */
    private $lodgingCollection;

    public function __construct()
    {
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

    /**
     * @ORM\PrePersist
     */
    public function setIdValue()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
    }

    public function getLodgingCategory(): ?LodgingCategory
    {
        return $this->lodgingCategory;
    }

    public function setLodgingCategory(?LodgingCategory $lodgingCategory): self
    {
        $this->lodgingCategory = $lodgingCategory;

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
            $lodgingCollection->setLodgingType($this);
        }

        return $this;
    }

    public function removeLodgingCollection(Lodging $lodgingCollection): self
    {
        if ($this->lodgingCollection->removeElement($lodgingCollection)) {
            // set the owning side to null (unless already changed)
            if ($lodgingCollection->getLodgingType() === $this) {
                $lodgingCollection->setLodgingType(null);
            }
        }

        return $this;
    }
}
