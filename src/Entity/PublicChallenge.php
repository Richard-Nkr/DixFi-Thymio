<?php

namespace App\Entity;

use App\Repository\PublicChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicChallengeRepository::class)
 */
class PublicChallenge extends Challenge
{

    /**
     * @ORM\Column(type="string", length=30)
     */
    private $nameCorrectionPDF;

    /**
     * @ORM\Column(type="integer")
     */
    private $idTeacher;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getNameCorrectionPDF(): ?string
    {
        return $this->nameCorrectionPDF;
    }

    public function setNameCorrectionPDF(string $nameCorrectionPDF): self
    {
        $this->nameCorrectionPDF = $nameCorrectionPDF;

        return $this;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
