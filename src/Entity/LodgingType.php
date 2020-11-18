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
     * @Groups({"public_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read"})
     */
    private $label;


    /**
     * @ORM\ManyToOne(targetEntity=LodgingCategory::class, inversedBy="lodgingType")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"public_read"})
     */
    private $lodgingCategory;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="lodgingType", cascade={"persist", "remove"})
     */
    private $lodgingCollection;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->lodgingCollection = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): self
    {
        $this->label = $label;

        return $this;
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
