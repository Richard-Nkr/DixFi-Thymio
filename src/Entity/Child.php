<?php

namespace App\Entity;

use App\Repository\ChildrenRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChildrenRepository::class)
 */
class Child
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
    private $nameChild;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $firstNameChild;

    /**
     * @ORM\ManyToOne(targetEntity=StudentGroup::class, inversedBy="children")
     * @ORM\JoinColumn(nullable=false)
     */
    private $groupChild;

    public function getId(): ?int
    {
        return $this->id;
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


    public function getFirstNameChild(): ?string
    {
        return $this->firstNameChild;
    }

    public function setFirstNameChild(string $firstNameChild): self
    {
        $this->firstNameChild= $firstNameChild;

        return $this;
    }

    public function getGroupChild(): ?StudentGroup
    {
        return $this->groupChild;
    }

    public function setGroupChild(?StudentGroup $groupChild): self
    {
        $this->groupChild = $groupChild;

        return $this;
    }
}
