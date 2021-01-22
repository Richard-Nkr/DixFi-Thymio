<?php

namespace App\Entity;

use App\Repository\ChildrenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChildrenRepository::class)
 */
class Children
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $idChildren;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nameChild;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $Teacher;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nameTeacher;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstNameTeacher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdChildren(): ?int
    {
        return $this->idChildren;
    }

    public function setIdChildren(int $idChildren): self
    {
        $this->idChildren = $idChildren;

        return $this;
    }

    public function getNameChild(): ?string
    {
        return $this->nameChild;
    }

    public function setNameChild(string $nameChild): self
    {
        $this->nameChild = $nameChild;

        return $this;
    }

    public function getTeacher(): ?string
    {
        return $this->Teacher;
    }

    public function setTeacher(string $Teacher): self
    {
        $this->Teacher = $Teacher;

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
}
