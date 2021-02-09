<?php

namespace App\Entity;

use App\Repository\ThymioChallengeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ThymioChallengeRepository::class)
 */
class ThymioChallenge extends Challenge
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

}
