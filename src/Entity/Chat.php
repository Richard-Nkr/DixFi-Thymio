<?php

namespace App\Entity;

use App\Repository\ChatRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChatRepository::class)
 */
class Chat
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
    private $idTeacher;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdTeacher(): ?int
    {
        return $this->idTeacher;
    }

    public function setIdTeacher(int $idTeacher): self
    {
        $this->idTeacher = $idTeacher;

        return $this;
    }
}
