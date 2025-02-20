<?php

namespace ZHC\PhonebookBundle\Entity;

use ZHC\PhonebookBundle\Repository\PhonebookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=PhonebookRepository::class)
 * @UniqueEntity(fields={"name"}, message="Nom de l'annuaire déjà existant")
 */
class Phonebook
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
     * @ORM\Column(type="array", length=255)
     */
    private $roles_management;

    /**
     * @ORM\Column(type="array", length=255)
     */
    private $roles_visibility;

    /**
     * @ORM\ManyToMany(targetEntity="ZHC\PhonebookBundle\Entity\Number", mappedBy="phonebooks")
     * @ORM\JoinColumn(nullable=true)
     */
    private $numbers;

    public function __construct()
    {
        $this->numbers = new ArrayCollection();
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

    public function getRolesManagement(): ?array
    {
        return $this->roles_management;
    }

    public function setRolesManagement(array $roles_management): self
    {
        $this->roles_management = $roles_management;

        return $this;
    }

    public function getRolesVisibility(): ?array
    {
        return $this->roles_visibility;
    }

    public function setRolesVisibility(array $roles_visibility): self
    {
        $this->roles_visibility = $roles_visibility;

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
            $number->addPhonebook($this);
        }

        return $this;
    }

    public function removeNumber(Number $number): self
    {
        if ($this->numbers->contains($number)) {
            $this->numbers->removeElement($number);
            $number->removePhonebook($this);
        }

        return $this;
    }
}
