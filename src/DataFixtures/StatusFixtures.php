<?php


namespace App\DataFixtures;


use App\Entity\Status;
use App\Entity\StudentGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class StatusFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbStatus = 1; $nbStatus <= 40; $nbStatus++){
            $studentGroup = $this->getReference('studentGroup_'. $faker->numberBetween(1, 20));
            $challenge = $this->getReference('thymioChallenge_'. $faker->numberBetween(1, 10));

            $status = new Status();
            $status->setStudentGroup($studentGroup);
            $status->setChallenge($challenge);
            $status->setStatusInt($faker->numberBetween(1,3));
            $status->setStartedAt($faker->dateTime);

            if ($status->getStatusInt()==2){
                $status->setSubmittedAt($faker->dateTime());
            }
            if ($status->getStatusInt()==3){
                $status->setSubmittedAt($faker->dateTime());
                $status->setFinishedAt($faker->dateTime());
            }
            if ($status->getStatusInt()==-1 || $status->getStatusInt()==3 || $status->getStatusInt()==2){
                $status->setComment($faker->realText(100));
            }
            $status->setCountHelp(null);
            $status->setNeedHelp(false);

            $manager->persist($status);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            StudentGroupFixtures::class,
            ThymioChallengeFixtures::class
        ];
    }
}