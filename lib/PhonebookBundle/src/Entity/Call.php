<?php

namespace ZHC\PhonebookBundle\Entity;

use ZHC\PhonebookBundle\Repository\CallRepository;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CallRepository::class)
 * @ORM\Table(name="`call`")
 */
class Call
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="calls")
     * @ORM\JoinColumn(nullable=false)
     */
    private $userIn;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $userOut;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getUserIn(): ?User
    {
        return $this->userIn;
    }

    public function setUserIn(?User $userIn): self
    {
        $this->userIn = $userIn;

        return $this;
    }

    public function getUserOut(): ?User
    {
        return $this->userOut;
    }

    public function setUserOut(?User $userOut): self
    {
        $this->userOut = $userOut;

        return $this;
    }
}
