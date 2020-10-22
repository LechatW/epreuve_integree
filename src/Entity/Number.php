<?php

namespace App\Entity;

use App\Repository\NumberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NumberRepository::class)
 */
class Number
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
     * @ORM\Column(type="string", length=20, unique=true)
     */
    private $phoneNumber;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\Phonebook", inversedBy="numbers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $phonebooks;

    public function __construct()
    {
        $this->phonebooks = new ArrayCollection();
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

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): self
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    /**
     * @return Collection|Phonebook[]
     */
    public function getPhonebooks(): Collection
    {
        return $this->phonebooks;
    }

    public function addPhonebook(Phonebook $phonebook): self
    {
        if (!$this->phonebooks->contains($phonebook)) {
            $this->phonebooks[] = $phonebook;
        }

        return $this;
    }

    public function removePhonebook(Phonebook $phonebook): self
    {
        if ($this->phonebooks->contains($phonebook)) {
            $this->phonebooks->removeElement($phonebook);
        }

        return $this;
    }
}
