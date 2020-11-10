<?php

namespace App\Entity;

use App\Repository\SessionRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SessionRepository::class)
 * @UniqueEntity(fields={"name"}, message="Nom de session déjà existant")
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
     * @ORM\Column(type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=Training::class, inversedBy="sessions")
     */
    private $training;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\LessThan(propertyPath="endAt", message="Doit être inférieur que l'heure de fin")
     */
    private $startAt;

    /**
     * @ORM\Column(type="datetime")
     * @Assert\GreaterThan(propertyPath="startAt", message="Doit être supérieur que l'heure de début")
     */
    private $endAt;

    /**
     * @ORM\Column(type="date")
     * @Assert\LessThan(propertyPath="registrationEndAt", message="Doit être inférieur que la date de fin d'inscription")
     */
    private $registrationStartAt;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="registrationStartAt", message="Doit être supérieur que la date de début d'inscription")
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

    /**
     * @ORM\Column(type="string", length=30, nullable=true)
     */
    private $frequency;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $frequencyInterval;

    /**
     * @ORM\Column(type="array", nullable=true)
     */
    private $days = [];

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

    public function getFrequency(): ?string
    {
        return $this->frequency;
    }

    public function setFrequency(?string $frequency): self
    {
        $this->frequency = $frequency;

        return $this;
    }

    public function getFrequencyInterval(): ?int
    {
        return $this->frequencyInterval;
    }

    public function setFrequencyInterval(?int $frequencyInterval): self
    {
        $this->frequencyInterval = $frequencyInterval;

        return $this;
    }

    public function getDays(): ?array
    {
        return $this->days;
    }

    public function setDays(?array $days): self
    {
        $this->days = $days;

        return $this;
    }
}
