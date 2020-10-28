<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ZHC\PhonebookBundle\Entity\Call;
use ZHC\PhonebookBundle\Entity\Number;
use ZHC\PhonebookBundle\Entity\Phone;
use App\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @UniqueEntity(fields={"login"}, message="Login déjà existant")
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
     * @ORM\Column(type="string", length=255, unique=true)
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

    /**
     * @ORM\OneToOne(targetEntity=Phone::class, inversedBy="user", cascade={"persist", "remove"})
     */
    private $phone;

    /**
     * @ORM\OneToMany(targetEntity=UserSession::class, mappedBy="user", cascade={"persist", "remove"})
     */
    private $userSessions;

    /**
     * @ORM\OneToMany(targetEntity=Training::class, mappedBy="contact", cascade={"persist", "remove"})
     */
    private $trainings;

    public function __construct()
    {
        $this->calls = new ArrayCollection();
        $this->numbers = new ArrayCollection();
        $this->userSessions = new ArrayCollection();
        $this->trainings = new ArrayCollection();
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

    public function getRoles(): array
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

    public function getPhone(): ?Phone
    {
        return $this->phone;
    }

    public function setPhone(?Phone $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * @return Collection|UserSession[]
     */
    public function getUserSessions(): Collection
    {
        return $this->userSessions;
    }

    public function addUserSession(UserSession $userSession): self
    {
        if (!$this->userSessions->contains($userSession)) {
            $this->userSessions[] = $userSession;
            $userSession->setUser($this);
        }

        return $this;
    }

    public function removeUserSession(UserSession $userSession): self
    {
        if ($this->userSessions->contains($userSession)) {
            $this->userSessions->removeElement($userSession);
        }

        return $this;
    }

    /**
     * @return Collection|Training[]
     */
    public function getTrainings(): Collection
    {
        return $this->trainings;
    }

    public function addTraining(Training $training): self
    {
        if (!$this->trainings->contains($training)) {
            $this->trainings[] = $training;
            $training->setContact($this);
        }

        return $this;
    }

    public function removeTraining(Training $training): self
    {
        if ($this->trainings->contains($training)) {
            $this->trainings->removeElement($training);
            // set the owning side to null (unless already changed)
            if ($training->getContact() === $this) {
                $training->setContact(null);
            }
        }

        return $this;
    }

}
