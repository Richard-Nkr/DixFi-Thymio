<?php

namespace App\Entity;

use App\Repository\GroupRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GroupRepository::class)
 * @ORM\Table(name="`group`")
 */
class Group
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $idTeacher;

    /**
     * @ORM\Column(type="integer")
     */
    private $countSucceed;



    public function getIdTeacher(): ?int
    {
        return $this->idTeacher;
    }

    public function setIdTeacher(int $idTeacher): self
    {
        $this->idTeacher = $idTeacher;

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
}
