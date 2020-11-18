<?php

namespace App\Entity;

use App\Repository\LodgingCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Serializer\Annotation\Groups;



/**
 * @ORM\Entity(repositoryClass=LodgingCategoryRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class LodgingCategory
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read"})
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=LodgingType::class, mappedBy="lodgingCategory", orphanRemoval=true)
     */
    private $lodgingType;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->lodgingType = new ArrayCollection();
    }


    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $name): self
    {
        $this->label = $name;

        return $this;
    }

    /**
     * @return Collection|LodgingType[]
     */
    public function getLodgingType(): Collection
    {
        return $this->lodgingType;
    }

    public function addLodgingType(LodgingType $lodgingType): self
    {
        if (!$this->lodgingType->contains($lodgingType)) {
            $this->lodgingType[] = $lodgingType;
            $lodgingType->setLodgingCategory($this);
        }

        return $this;
    }

    public function removeLodgingType(LodgingType $lodgingType): self
    {
        if ($this->lodgingType->removeElement($lodgingType)) {
            // set the owning side to null (unless already changed)
            if ($lodgingType->getLodgingCategory() === $this) {
                $lodgingType->setLodgingCategory(null);
            }
        }

        return $this;
    }

}
