<?php

namespace App\Entity;

use App\Repository\LodgingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=LodgingTypeRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class LodgingType
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
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="lodgingType")
     */
    private $lodgingCollection;

    /**
     * @ORM\ManyToMany(targetEntity=LodgingCategory::class, inversedBy="lodgingTypes")
     */
    private $lodgingCategoryCollection;

    public function __construct()
    {
        $this->lodgingCollection = new ArrayCollection();
        $this->lodgingCategoryCollection = new ArrayCollection();
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

    /**
     * @return Collection|LodgingCategory[]
     */
    public function getLodgingCategoryCollection(): Collection
    {
        return $this->lodgingCategoryCollection;
    }

    public function addLodgingCategoryCollection(LodgingCategory $lodgingCategoryCollection): self
    {
        if (!$this->lodgingCategoryCollection->contains($lodgingCategoryCollection)) {
            $this->lodgingCategoryCollection[] = $lodgingCategoryCollection;
        }

        return $this;
    }

    public function removeLodgingCategoryCollection(LodgingCategory $lodgingCategoryCollection): self
    {
        $this->lodgingCategoryCollection->removeElement($lodgingCategoryCollection);

        return $this;
    }
}
