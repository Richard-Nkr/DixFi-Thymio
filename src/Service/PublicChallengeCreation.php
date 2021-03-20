<?php


namespace App\Service;


use App\Entity\Challenge;
use App\Entity\PublicChallenge;
use App\Entity\Teacher;

class PublicChallengeCreation
{
    public function makePublicChallenge(Challenge $challenge, Teacher $teacher): PublicChallenge
    {
        $publicChallenge = new PublicChallenge();
        $publicChallenge->setCreatedAt(new \DateTime('now'));
        $publicChallenge->setName($challenge->getName());
        $publicChallenge->setDescription($challenge->getDescription());
        $publicChallenge->setDifficulty($challenge->getDifficulty());
        $publicChallenge->setDuration($challenge->getDuration());
        $publicChallenge->setTeacher($teacher);
        $publicChallenge->setRole($challenge->getRole());

        return $publicChallenge;
    }

    public function verifExtension(String $extension): bool
    {
        if(($extension==="jpg") || ($extension ==="jpeg") || ($extension ==="png")){
            return true;
        }
        return false;
    }

}