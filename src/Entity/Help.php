<?php

namespace App\Entity;

use App\Repository\HelpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=HelpRepository::class)
 */
class Help
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     */
    private $contentHelp;


    /**
     * @ORM\ManyToOne(targetEntity=Challenge::class, inversedBy="helps")
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $challenge;

    /**
     * @ORM\Column(type="integer")
     */
    private $numberHelp;

    /**
     * @ORM\ManyToMany(targetEntity=User::class, mappedBy="helps_checked")
     */
    private $users;

    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContentHelp(): ?string
    {
        return $this->contentHelp;
    }

    public function setContentHelp(string $contentHelp): self
    {
        $this->contentHelp = $contentHelp;

        return $this;
    }

    /**
     * @return Collection|StudentGroup[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup(StudentGroup $studentGroup): self
    {
        if (!$this->groups->contains($studentGroup)) {
            $this->groups[] = $studentGroup;
            $studentGroup->addHelp($this);
        }

        return $this;
    }

    public function removeGroup(StudentGroup $studentGroup): self
    {
        if ($this->groups->removeElement($studentGroup)) {
            $studentGroup->removeHelp($this);
        }

        return $this;
    }

    public function getChallenge(): ?Challenge
    {
        return $this->challenge;
    }

    public function setChallenge(?Challenge $challenge): self
    {
        $this->challenge = $challenge;

        return $this;
    }

    public function getNumberHelp(): ?int
    {
        return $this->numberHelp;
    }

    public function setNumberHelp(int $numberHelp): self
    {
        $this->numberHelp = $numberHelp;

        return $this;
    }

    /**
     * @return Collection|User[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->addHelpsChecked($this);
        }

        return $this;
    }

    public function removeUser(User $user): self
    {
        if ($this->users->removeElement($user)) {
            $user->removeHelpsChecked($this);
        }

        return $this;
    }
}
