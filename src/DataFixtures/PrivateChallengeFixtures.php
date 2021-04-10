<?php


namespace App\DataFixtures;


use App\Entity\PrivateChallenge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PrivateChallengeFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('frFR');

        for ($nbStatus = 1; $nbStatus <= 20; $nbStatus++) {
            $teacher = $this->getReference('teacher_' . $faker->numberBetween(2, 10));

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