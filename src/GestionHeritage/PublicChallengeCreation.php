<?php


namespace App\GestionHeritage;


use App\Entity\Challenge;
use App\Entity\PublicChallenge;
use App\Entity\User;
use App\Repository\TeacherRepository;
use App\Repository\UserRepository;
use MongoDB\Driver\Session;

class PublicChallengeCreation
{
    public function makeTeacher(Challenge $challenge, TeacherRepository $teacherRepository, Session $session): PublicChallenge
    {
        $publicChallenge = new PublicChallenge();
        $publicChallenge->setCreatedAt(new \DateTime('now'));
        $publicChallenge->setName($challenge->getName());
        $publicChallenge->setDescription($challenge->getDescription());
        $publicChallenge->setDifficulty($challenge->getDifficulty());
        $publicChallenge->setDuration($challenge->getDuration());
        $publicChallenge->setTeacher();
        $publicChallenge->setNameCorrectionPDF();

        return $publicChallenge;
    }
}