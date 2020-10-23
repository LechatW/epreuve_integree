<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 */
class User implements UserInterface
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
    private $login;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\OneToMany(targetEntity=Call::class, mappedBy="userIn")
     * @ORM\JoinColumn(nullable=true)
     */
    private $calls;

    /**
     * @ORM\OneToMany(targetEntity=Number::class, mappedBy="user")
     * @ORM\JoinColumn(nullable=true)
     */
    private $numbers;

    public function __construct()
    {
        $this->calls = new ArrayCollection();
        $this->numbers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogin(): ?string
    {
        return $this->login;
    }

    public function setLogin(string $login): self
    {
        $this->login = $login;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getRoles(): ?array
    {
        $roles = $this->roles;

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials()
    {
        
    }

    public function getSalt()
    {
        
    }

    public function getUsername(): ?string
    {
        return $this->login;
    }

    public function isGranted($role)
    {
        return in_array($role, $this->getRoles());
    }

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return Collection|Call[]
     */
    public function getCalls(): Collection
    {
        return $this->calls;
    }

    public function addCall(Call $call): self
    {
        if (!$this->calls->contains($call)) {
            $this->calls[] = $call;
            $call->setUserIn($this);
        }

        return $this;
    }

    public function removeCall(Call $call): self
    {
        if ($this->calls->contains($call)) {
            $this->calls->removeElement($call);
            // set the owning side to null (unless already changed)
            if ($call->getUserIn() === $this) {
                $call->setUserIn(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Number[]
     */
    public function getNumbers(): Collection
    {
        return $this->numbers;
    }

    public function addNumber(Number $number): self
    {
        if (!$this->numbers->contains($number)) {
            $this->numbers[] = $number;
            $number->setUser($this);
        }

        return $this;
    }

    public function removeNumber(Number $number): self
    {
        if ($this->numbers->contains($number)) {
            $this->numbers->removeElement($number);
            // set the owning side to null (unless already changed)
            if ($number->getUser() === $this) {
                $number->setUser(null);
            }
        }

        return $this;
    }
}
