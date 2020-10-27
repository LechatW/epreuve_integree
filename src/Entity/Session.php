<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 */
class Session
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
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="sessions")
     */
    private $training;

    /**
     * @ORM\Column(type="datetime")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $endAt;

    /**
     * @ORM\Column(type="date")
     */
    private $registrationStartAt;

    /**
     * @ORM\Column(type="date")
     */
    private $registrationEndAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $location;

    /**
     * @ORM\Column(type="integer")
     */
    private $maxRegistration;

    /**
     * @ORM\OneToMany(targetEntity=UserSession::class, mappedBy="session", cascade={"persist", "remove"})
     */
    private $userSessions;

    public function __construct()
    {
        $this->userSessions = new ArrayCollection();
    }

    public function getId(): ?int
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

    public function getTraining(): ?Training
    {
        return $this->training;
    }

    public function setTraining(?Training $training): self
    {
        $this->training = $training;

        return $this;
    }

    public function getStartAt(): ?\DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(\DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    public function getEndAt(): ?\DateTimeInterface
    {
        return $this->endAt;
    }

    public function setEndAt(\DateTimeInterface $endAt): self
    {
        $this->endAt = $endAt;

        return $this;
    }

    public function getRegistrationStartAt(): ?\DateTimeInterface
    {
        return $this->registrationStartAt;
    }

    public function setRegistrationStartAt(\DateTimeInterface $registrationStartAt): self
    {
        $this->registrationStartAt = $registrationStartAt;

        return $this;
    }

    public function getRegistrationEndAt(): ?\DateTimeInterface
    {
        return $this->registrationEndAt;
    }

    public function setRegistrationEndAt(\DateTimeInterface $registrationEndAt): self
    {
        $this->registrationEndAt = $registrationEndAt;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getMaxRegistration(): ?int
    {
        return $this->maxRegistration;
    }

    public function setMaxRegistration(int $maxRegistration): self
    {
        $this->maxRegistration = $maxRegistration;

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
            $userSession->setSession($this);
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
}
