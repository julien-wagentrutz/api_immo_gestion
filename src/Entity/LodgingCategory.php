<?php

namespace App\Entity;

use App\Repository\LodgingCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=LodgingCategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class LodgingCategory
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
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="lodgingCategory")
     */
    private $lodgingCollection;

    /**
     * @ORM\ManyToMany(targetEntity=LodgingType::class, mappedBy="lodgingCategoryCollection")
     */
    private $lodgingTypes;

    public function __construct()
    {
        $this->lodgingCollection = new ArrayCollection();
        $this->lodgingTypes = new ArrayCollection();
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
            $lodgingCollection->setLodgingCategory($this);
        }

        return $this;
    }

    public function removeLodgingCollection(Lodging $lodgingCollection): self
    {
        if ($this->lodgingCollection->removeElement($lodgingCollection)) {
            // set the owning side to null (unless already changed)
            if ($lodgingCollection->getLodgingCategory() === $this) {
                $lodgingCollection->setLodgingCategory(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|LodgingType[]
     */
    public function getLodgingTypes(): Collection
    {
        return $this->lodgingTypes;
    }

    public function addLodgingType(LodgingType $lodgingType): self
    {
        if (!$this->lodgingTypes->contains($lodgingType)) {
            $this->lodgingTypes[] = $lodgingType;
            $lodgingType->addLodgingCategoryCollection($this);
        }

        return $this;
    }

    public function removeLodgingType(LodgingType $lodgingType): self
    {
        if ($this->lodgingTypes->removeElement($lodgingType)) {
            $lodgingType->removeLodgingCategoryCollection($this);
        }

        return $this;
    }
}
