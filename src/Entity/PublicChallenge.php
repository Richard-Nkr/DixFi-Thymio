<?php

namespace App\Entity;

use App\Repository\PublicChallengeRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass=PublicChallengeRepository::class)
 * @Vich\Uploadable
 */
class PublicChallenge extends Challenge
{

    /**
     * @ORM\Column(type="string",length=30, nullable=true)
     *
     * @var string | null
     */
    private $nameCorrection;


    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     *
     * @Vich\UploadableField(mapping="correction", fileNameProperty="nameCorrection")
     *
     * @var File
     */
    private $fileCorrection;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\ManyToOne(targetEntity=Teacher::class, inversedBy="publicChallenges")
     * @ORM\JoinColumn(nullable=false)
     */
    private $teacher;


    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    public function getNameCorrection(): ?string
    {
        return $this->nameCorrection;
    }

    public function setNameCorrection(string $nameCorrection): self
    {
        $this->nameCorrection = $nameCorrection;

        return $this;
    }

    public function getFileCorrection(): ?File
    {
        return $this->fileCorrection;
    }

    /**
     * @param File|UploadedFile|null $fileCorrection
     */
    public function setFileCorrection(?File $fileCorrection = null): void
    {
        $this->fileCorrection = $fileCorrection;

        if (null !== $fileCorrection) {
            $this->updateAt = new \DateTimeImmutable();
        }
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

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): self
    {
        $this->teacher = $teacher;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(?\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }
}
