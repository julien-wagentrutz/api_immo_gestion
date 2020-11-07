<?php

namespace App\Entity;

use App\Repository\CollectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection as CollectionDoctrine;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=CollectionRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Collection
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
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="collection")
     */
    private $lodgingItems;

    public function __construct()
    {
        $this->lodgingItems = new ArrayCollection();
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
    public function getLodgingItems(): CollectionDoctrine
    {
        return $this->lodgingItems;
    }

    public function addLodgingItem(Lodging $lodgingItem): self
    {
        if (!$this->lodgingItems->contains($lodgingItem)) {
            $this->lodgingItems[] = $lodgingItem;
            $lodgingItem->setCollection($this);
        }

        return $this;
    }

    public function removeLodgingItem(Lodging $lodgingItem): self
    {
        if ($this->lodgingItems->removeElement($lodgingItem)) {
            // set the owning side to null (unless already changed)
            if ($lodgingItem->getCollection() === $this) {
                $lodgingItem->setCollection(null);
            }
        }

        return $this;
    }
}
