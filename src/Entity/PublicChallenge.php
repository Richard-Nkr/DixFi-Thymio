<?php

namespace App\Entity;

use App\Repository\PublicChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PublicChallengeRepository::class)
 */
class PublicChallenge
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
    private $nameCorrectionPDF;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNameCorrectionPDF(): ?string
    {
        return $this->nameCorrectionPDF;
    }

    public function setNameCorrectionPDF(string $nameCorrectionPDF): self
    {
        $this->nameCorrectionPDF = $nameCorrectionPDF;

        return $this;
    }
}
