<?php

namespace ZHC\PhonebookBundle\Entity;

use ZHC\PhonebookBundle\Repository\NumberRepository;
use ZHC\PhonebookBundle\Entity\Phonebook;
use ZHC\PhonebookBundle\Entity\Phone;
use App\Entity\User;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=NumberRepository::class)
 * @UniqueEntity(fields={"phoneNumber"}, message="Numéro déjà existant")
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
     * @ORM\ManyToMany(targetEntity="ZHC\PhonebookBundle\Entity\Phonebook", inversedBy="numbers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $phonebooks;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $type;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="numbers")
     * @ORM\JoinColumn(nullable=true)
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Phone::class, mappedBy="numbers")
     */
    private $phones;

    public function __construct()
    {
        $this->phonebooks = new ArrayCollection();
        $this->phones = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection|Phone[]
     */
    public function getPhones(): Collection
    {
        return $this->phones;
    }

    public function addPhone(Phone $phone): self
    {
        if (!$this->phones->contains($phone)) {
            $this->phones[] = $phone;
            $phone->addNumber($this);
        }

        return $this;
    }

    public function removePhone(Phone $phone): self
    {
        if ($this->phones->contains($phone)) {
            $this->phones->removeElement($phone);
            $phone->removeNumber($this);
        }

        return $this;
    }
}
