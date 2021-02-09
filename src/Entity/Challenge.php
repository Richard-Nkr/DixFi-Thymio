<?php

namespace App\Entity;

use App\Repository\ChallengeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChallengeRepository::class)
 * @ORM\InheritanceType("JOINED")
 * @ORM\DiscriminatorColumn(name="type", type="string")
 * @ORM\DiscriminatorMap({
 *     "challenge"="Challenge",
 *     "pivate_challenge"="PrivateChallenge",
 *     "public_challenge"="PublicChallenge",
 *     "thymio_challenge"="ThymioChallenge",
 * })
 */
class Challenge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $difficulty;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="challenge")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=StudentGroup::class, inversedBy="challenges")
     */
    private $groups;

    /**
     * @ORM\OneToMany(targetEntity=Help::class, mappedBy="challenge")
     */
    private $helps;


    public function __construct()
    {
        $this->status = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->helps = new ArrayCollection();
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

    public function getDifficulty(): ?int
    {
        return $this->difficulty;
    }

    public function setDifficulty(string $difficulty): self
    {
        $this->difficulty = $difficulty;

        return $this;
    }

    /**
     * @return Collection|Status[]
     */
    public function getStatus(): Collection
    {
        return $this->status;
    }

    public function addStatus(Status $status): self
    {
        if (!$this->status->contains($status)) {
            $this->status[] = $status;
            $status->setChallenge($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->status->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getChallenge() === $this) {
                $status->setChallenge(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|StudentGroup[]
     */
    public function getGroups(): Collection
    {
        return $this->groups;
    }

    public function addGroup($studentGroup): self
    {
        if (!$this->groups->contains($studentGroup)) {
            $this->groups[] = $studentGroup;
        }

        return $this;
    }

    public function removeGroup(StudentGroup $studentGroup): self
    {
        $this->groups->removeElement($studentGroup);

        return $this;
    }

    /**
     * @return Collection|Help[]
     */
    public function getHelps(): Collection
    {
        return $this->helps;
    }

    public function addHelp(Help $help): self
    {
        if (!$this->helps->contains($help)) {
            $this->helps[] = $help;
            $help->setChallenge($this);
        }

        return $this;
    }

    public function removeHelp(Help $help): self
    {
        if ($this->helps->removeElement($help)) {
            // set the owning side to null (unless already changed)
            if ($help->getChallenge() === $this) {
                $help->setChallenge(null);
            }
        }

        return $this;
    }
}
