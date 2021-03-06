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
class Teacher extends User
{

    /**
     * @ORM\Column(type="string", length=150)
     */
    private $mailTeacher;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $nameTeacher;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $firstNameTeacher;

    /**
     * @ORM\OneToMany(targetEntity=Comment::class, mappedBy="teacher")
     */
    private $comments;

    /**
     * @ORM\OneToMany(targetEntity=StudentGroup::class, mappedBy="teacher")
     */
    private $groups;

    /**
     * @ORM\OneToOne(targetEntity=Chat::class, inversedBy="teacher", cascade={"persist", "remove"})
     * @ORM\JoinColumn
     */
    private $chat;


    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->groups = new ArrayCollection();
    }

    public function getMailTeacher(): ?string
    {
        return $this->mailTeacher;
    }

    public function setMailTeacher(string $mailTeacher): self
    {
        $this->mailTeacher = $mailTeacher;

        return $this;
    }

    public function getNameTeacher(): ?string
    {
        return $this->nameTeacher;
    }

    public function setNameTeacher(string $nameTeacher): self
    {
        $this->nameTeacher = $nameTeacher;

        return $this;
    }

    public function getFirstNameTeacher(): ?string
    {
        return $this->firstNameTeacher;
    }

    public function setFirstNameTeacher(string $firstNameTeacher): self
    {
        $this->firstNameTeacher = $firstNameTeacher;

        return $this;
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
}
