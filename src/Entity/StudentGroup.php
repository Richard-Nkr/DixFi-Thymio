<?php

namespace App\Entity;

use App\Repository\StudentGroupRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StudentGroupRepository::class)
 * @ORM\Table(name="`student_group`")
 */
class StudentGroup extends User
{

    /**
     * @ORM\Column(type="integer")
     */
    private $countSucceed;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="groups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;

    /**
     * @ORM\OneToMany(targetEntity=Child::class, mappedBy="groupChild")
     */
    private $children;

    /**
     * @ORM\ManyToMany(targetEntity=Help::class, inversedBy="groups")
     */
    private $helps;

    /**
     * @ORM\OneToMany(targetEntity=Status::class, mappedBy="groupStatus")
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Challenge::class, mappedBy="groups")
     */
    private $challenges;

    /**
     * @ORM\ManyToOne(targetEntity=Chat::class, inversedBy="groups")
     * @ORM\JoinColumn(name="chat_id", nullable=false)
     */
    private $chat;



    public function __construct()
    {
        $this->children = new ArrayCollection();
        $this->helps = new ArrayCollection();
        $this->status = new ArrayCollection();
        $this->challenges = new ArrayCollection();
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

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * @return Collection|Child[]
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children[] = $child;
            $child->setGroupChild($this);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        if ($this->children->removeElement($child)) {
            // set the owning side to null (unless already changed)
            if ($child->getGroupChild() === $this) {
                $child->setGroupChild(null);
            }
        }

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
        }

        return $this;
    }

    public function removeHelp(Help $help): self
    {
        $this->helps->removeElement($help);

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
            $status->setGroupStatus($this);
        }

        return $this;
    }

    public function removeStatus(Status $status): self
    {
        if ($this->status->removeElement($status)) {
            // set the owning side to null (unless already changed)
            if ($status->getGroupStatus() === $this) {
                $status->setGroupStatus(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Challenge[]
     */
    public function getChallenges(): Collection
    {
        return $this->challenges;
    }

    public function addChallenge(Challenge $challenge): self
    {
        if (!$this->challenges->contains($challenge)) {
            $this->challenges[] = $challenge;
            $challenge->addGroup($this);
        }

        return $this;
    }

    public function removeChallenge(Challenge $challenge): self
    {
        if ($this->challenges->removeElement($challenge)) {
            $challenge->removeGroup($this);
        }

        return $this;
    }

    public function getChat(): ?Chat
    {
        return $this->chat;
    }

    public function setChat(?Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

}
