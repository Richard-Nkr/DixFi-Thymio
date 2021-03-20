<?php

namespace App\Entity;

use App\Repository\UserGuestRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserGuestRepository::class)
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="`user_guest`")
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "user_guest"="UserGuest",
 *     "teacher"="Teacher",
 * })
 */
class UserGuest extends User
{


    /**
     * @ORM\Column(type="string", length=30)
     * @Assert\Email(
     *     message = "L'adresse mail '{{ value }}' n'est pas une adresse valide."
     * )
     */
    private $mail;

    /**
     * @ORM\Column(type="integer")
     */
    private $countSucceed;


    /**
     * @ORM\Column(type="string", length=30)
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $firstname;

    /**
     * @ORM\OneToMany(targetEntity=UserGuestStatus::class, mappedBy="userGuest")
     */
    private $Challenge;

    /**
     * @ORM\PrePersist
     */
    public function setCountSucceedValue(): void
    {
        $this->countSucceed = 0;
    }

    public function __construct()
    {
        $this->Challenge = new ArrayCollection();
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
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

    public function getCountSucceed(): ?int
    {
        return $this->countSucceed;
    }

    public function setCountSucceed(int $countSucceed): self
    {
        $this->countSucceed = $countSucceed;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * @return Collection|UserGuestStatus[]
     */
    public function getChallenge(): Collection
    {
        return $this->Challenge;
    }

    public function addChallenge(UserGuestStatus $challenge): self
    {
        if (!$this->Challenge->contains($challenge)) {
            $this->Challenge[] = $challenge;
            $challenge->setUserGuest($this);
        }

        return $this;
    }

    public function removeChallenge(UserGuestStatus $challenge): self
    {
        if ($this->Challenge->removeElement($challenge)) {
            if ($challenge->getUserGuest() === $this) {
                $challenge->setUserGuest(null);
            }
        }

        return $this;
    }

    public function __toString() : String
    {
        return $this->name;
    }
}
