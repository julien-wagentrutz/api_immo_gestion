<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Uid\Uuid;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class User implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="string", length=36, unique=true)
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToMany(targetEntity=Account::class, inversedBy="users")
     */
    private $accounts;

    /**
     * @ORM\OneToMany(targetEntity=Tenant::class, mappedBy="nameLastModifier")
     */
    private $tenantsModify;

    /**
     * @ORM\OneToMany(targetEntity=Lodging::class, mappedBy="nameLastModifier")
     */
    private $lodgingModify;

    /**
     * @ORM\ManyToOne(targetEntity=Account::class, inversedBy="usersLastAccount")
     * @ORM\JoinColumn(nullable=false)
     */
    private $lastAccountSelected;


    public function __construct()
    {
        $this->accounts = new ArrayCollection();
        $this->tenantsModify = new ArrayCollection();
        $this->lodgingModify = new ArrayCollection();
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist
     */
    public function setCreatedAtValue()
    {
        $this->createdAt = new \DateTime();
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
     * @return Collection|Account[]
     */
    public function getAccounts(): Collection
    {
        return $this->accounts;
    }

    public function addAccount(Account $account): self
    {
        if (!$this->accounts->contains($account)) {
            $this->accounts[] = $account;
        }

        return $this;
    }

    public function removeAccount(Account $account): self
    {
        $this->accounts->removeElement($account);

        return $this;
    }

    /**
     * @return Collection|Tenant[]
     */
    public function getTenantsModify(): Collection
    {
        return $this->tenantsModify;
    }

    public function addTenantsModify(Tenant $tenantsModify): self
    {
        if (!$this->tenantsModify->contains($tenantsModify)) {
            $this->tenantsModify[] = $tenantsModify;
            $tenantsModify->setUser($this);
        }

        return $this;
    }

    public function removeTenantsModify(Tenant $tenantsModify): self
    {
        if ($this->tenantsModify->removeElement($tenantsModify)) {
            // set the owning side to null (unless already changed)
            if ($tenantsModify->getUser() === $this) {
                $tenantsModify->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Lodging[]
     */
    public function getLodgingModify(): Collection
    {
        return $this->lodgingModify;
    }

    public function addLodgingModify(Lodging $lodgingModify): self
    {
        if (!$this->lodgingModify->contains($lodgingModify)) {
            $this->lodgingModify[] = $lodgingModify;
            $lodgingModify->setNameLastModifier($this);
        }

        return $this;
    }

    public function removeLodgingModify(Lodging $lodgingModify): self
    {
        if ($this->lodgingModify->removeElement($lodgingModify)) {
            // set the owning side to null (unless already changed)
            if ($lodgingModify->getNameLastModifier() === $this) {
                $lodgingModify->setNameLastModifier(null);
            }
        }

        return $this;
    }

    public function getLastAccountSelected(): ?Account
    {
        return $this->lastAccountSelected;
    }

    public function setLastAccountSelected(?Account $lastAccountSelected): self
    {
        $this->lastAccountSelected = $lastAccountSelected;

        return $this;
    }
}
