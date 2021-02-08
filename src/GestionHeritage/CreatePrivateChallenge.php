<?php


namespace App\GestionHeritage;


use App\Entity\Challenge;
use App\Entity\PrivateChallenge;

class CreatePrivateChallenge
{
    public function makeTeacher(Challenge $challenge): PrivateChallenge
    {
        $privateChallenge = new PrivateChallenge();
        $privateChallenge->setName();
        $privateChallenge->setCreatedAt(new \DateTime('now'));
        $privateChallenge->setDescription();
        $privateChallenge->setDifficulty();
        $privateChallenge->setDuration();
        $privateChallenge->setTeacher();

        return $privateChallenge;
    }

}