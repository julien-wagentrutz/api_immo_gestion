<?php

namespace App\Entity;

use App\Repository\RentRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Uid\Uuid;


/**
 * @ORM\Entity(repositoryClass=RentRepository::class)
 */
class Rent
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     * @Groups({"public_read"})
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"public_read"})
     */
    private $startRental;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Groups({"public_read"})
     */
    private $endRental;

    /**
     * @ORM\ManyToOne(targetEntity=Tenant::class, inversedBy="rents")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tenant;

    /**
     * @ORM\ManyToOne(targetEntity=Lodging::class, inversedBy="rents")
     * @ORM\JoinColumn(nullable=false)
     * @Groups({"public_read"})
     */
    private $lodging;

    public function __construct()
    {
        $uuid = Uuid::v4();;
        $this->id = $uuid->jsonSerialize();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getStartRental(): ?\DateTimeInterface
    {
        return $this->startRental;
    }

    public function setStartRental(\DateTimeInterface $startRental): self
    {
        $this->startRental = $startRental;

        return $this;
    }

    public function getEndRental(): ?\DateTimeInterface
    {
        return $this->endRental;
    }

    public function setEndRental(?\DateTimeInterface $endRental): self
    {
        $this->endRental = $endRental;

        return $this;
    }

    public function getTenant(): ?Tenant
    {
        return $this->tenant;
    }

    public function setTenant(?Tenant $tenant): self
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getLodging(): ?Lodging
    {
        return $this->lodging;
    }

    public function setLodging(?Lodging $lodging): self
    {
        $this->lodging = $lodging;

        return $this;
    }
}
