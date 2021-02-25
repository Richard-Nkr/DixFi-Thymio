<?php

namespace App\Entity;

use App\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeacherRepository::class)
 * @ORM\Table(name="`teacher`")
 */
class Teacher extends UserGuest
{

    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="teacher")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=StudentGroup::class, mappedBy="teacher")
     */
    private $groups;

    /**
     * @ORM\OneToOne(targetEntity=Chat::class, inversedBy="teacher")
     * @ORM\JoinColumn
     */
    private $chat;

    /**
     * @ORM\OneToMany(targetEntity=PrivateChallenge::class, mappedBy="teacher")
     */
    private $privateChallenges;

    /**
     * @ORM\OneToMany(targetEntity=PublicChallenge::class, mappedBy="teacher")
     */
    private $publicChallenges;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $progression;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->groups = new ArrayCollection();
        $this->privateChallenges = new ArrayCollection();
        $this->publicChallenges = new ArrayCollection();
    }


    /**
     * @return Collection|Comment[]
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments[] = $comment;
            $comment->setTeacher($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTeacher() === $this) {
                $comment->setTeacher(null);
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

    public function addGroup(StudentGroup $studentGroup): self
    {
        if (!$this->groups->contains($studentGroup)) {
            $this->groups[] = $studentGroup;
            $studentGroup->setTeacher($this);
        }

        return $this;
    }

    public function removeGroup(StudentGroup $studentGroup): self
    {
        if ($this->groups->removeElement($studentGroup)) {
            // set the owning side to null (unless already changed)
            if ($studentGroup->getTeacher() === $this) {
                $studentGroup->setTeacher(null);
            }
        }

        return $this;
    }

    public function getChat(): ?Chat
    {
        return $this->chat;
    }

    public function setChat(Chat $chat): self
    {
        $this->chat = $chat;

        return $this;
    }

    /**
     * @return Collection|PrivateChallenge[]
     */
    public function getPrivateChallenges(): Collection
    {
        return $this->privateChallenges;
    }

    public function addPrivateChallenge(PrivateChallenge $privateChallenge): self
    {
        if (!$this->privateChallenges->contains($privateChallenge)) {
            $this->privateChallenges[] = $privateChallenge;
            $privateChallenge->setTeacher($this);
        }

        return $this;
    }

    public function removePrivateChallenge(PrivateChallenge $privateChallenge): self
    {
        if ($this->privateChallenges->removeElement($privateChallenge)) {
            // set the owning side to null (unless already changed)
            if ($privateChallenge->getTeacher() === $this) {
                $privateChallenge->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|PublicChallenge[]
     */
    public function getPublicChallenges(): Collection
    {
        return $this->publicChallenges;
    }

    public function addPublicChallenge(PublicChallenge $publicChallenge): self
    {
        if (!$this->publicChallenges->contains($publicChallenge)) {
            $this->publicChallenges[] = $publicChallenge;
            $publicChallenge->setTeacher($this);
        }

        return $this;
    }

    public function removePublicChallenge(PublicChallenge $publicChallenge): self
    {
        if ($this->publicChallenges->removeElement($publicChallenge)) {
            // set the owning side to null (unless already changed)
            if ($publicChallenge->getTeacher() === $this) {
                $publicChallenge->setTeacher(null);
            }
        }

        return $this;
    }

    public function getProgression(): ?bool
    {
        return $this->progression;
    }

    public function setProgression(?bool $progression): self
    {
        $this->progression = $progression;

        return $this;
    }
}
