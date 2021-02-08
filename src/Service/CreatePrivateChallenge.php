<?php


namespace App\Service;


use App\Entity\Challenge;
use App\Entity\PrivateChallenge;
use App\Entity\Teacher;

class CreatePrivateChallenge
{
    public function makePrivateChallenge(Challenge $challenge, Teacher $teacher): PrivateChallenge
    {
        $privateChallenge = new PrivateChallenge();
        $privateChallenge->setName($challenge->getName());
        $privateChallenge->setCreatedAt(new \DateTime('now'));
        $privateChallenge->setDescription($challenge->getDescription());
        $privateChallenge->setDifficulty($challenge->getDifficulty());
        $privateChallenge->setDuration($challenge->getDuration());
        $privateChallenge->setTeacher($teacher);
        $privateChallenge->setRole($challenge->getRole());

        return $privateChallenge;
    }

}