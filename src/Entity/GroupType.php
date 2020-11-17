<?php

namespace App\Entity;

use App\Repository\GroupTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=GroupTypeRepository::class)
 */
class GroupType
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read_group_type"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Groups({"public_read_group_type"})
     */
    private $label;

    /**
     * @ORM\OneToMany(targetEntity=Group::class, mappedBy="groupType")
     * @Groups({"private_read_groups_type"})
     */
    private $groups;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
        $this->groups = new ArrayCollection();
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

    /**
     * @return Collection|Group[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(Group $group): self
    {
        if (!$this->groups->contains($group)) {
            $this->groups[] = $group;
            $group->setGroupType($this);
        }

        return $this;
    }

    public function removeGroup(Group $group): self
    {
        if ($this->groups->removeElement($group)) {
            // set the owning side to null (unless already changed)
            if ($group->getGroupType() === $this) {
                $group->setGroupType(null);
            }
        }

        return $this;
    }
}
