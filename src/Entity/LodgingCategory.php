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
     * @ORM\OneToMany(targetEntity=LodgingType::class, mappedBy="lodgingCategory")
     */
    private $types;

    public function __construct()
    {
        $this->types = new ArrayCollection();
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
     * @return Collection|LodgingType[]
     */
    public function getTypes(): Collection
    {
        return $this->types;
    }

    public function addType(LodgingType $type): self
    {
        if (!$this->types->contains($type)) {
            $this->types[] = $type;
            $type->setLodgingCategory($this);
        }

        return $this;
    }

    public function removeType(LodgingType $type): self
    {
        if ($this->types->removeElement($type)) {
            // set the owning side to null (unless already changed)
            if ($type->getLodgingCategory() === $this) {
                $type->setLodgingCategory(null);
            }
        }

        return $this;
    }
}
