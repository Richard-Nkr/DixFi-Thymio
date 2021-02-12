<?php

namespace App\Entity;

use App\Repository\UserGuestRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserGuestRepository::class)
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
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $firstname;

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

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }
}
