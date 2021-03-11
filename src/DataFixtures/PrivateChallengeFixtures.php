<?php


namespace App\DataFixtures;


use App\Entity\PrivateChallenge;
use App\Entity\PublicChallenge;
use App\Entity\Status;
use App\Entity\ThymioChallenge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PrivateChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($nbStatus = 1; $nbStatus <= 20; $nbStatus++) {
            $teacher = $this->getReference('teacher' . $faker->numberBetween(1, 20));

            $privateChallenge = new PrivateChallenge();
            $privateChallenge->setTeacher($teacher);
            $privateChallenge->setRole('ROLE_PRIVATE_CHALLENGE');
            $privateChallenge->setDuration('1heure');
            $privateChallenge->setName($faker->userName);
            $privateChallenge->setDifficulty('medium');
            $privateChallenge->setCreatedAt($faker->dateTime);
            $privateChallenge->setDescription($faker->realText(150));

            $manager->persist($privateChallenge);
        }
        $manager->flush();
    }

    public function getDependencies(): array
    {
        return [
            TeacherFixtures::class,
        ];
    }
}