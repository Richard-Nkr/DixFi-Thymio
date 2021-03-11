<?php


namespace App\DataFixtures;


use App\Entity\PublicChallenge;
use App\Entity\Status;
use App\Entity\ThymioChallenge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;

class PublicChallengesFixture extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for ($nbStatus = 1; $nbStatus <= 20; $nbStatus++) {
            $teacher = $this->getReference('teacher' . $faker->numberBetween(1, 20));

            $publicChallenge = new PublicChallenge();
            $publicChallenge->setTeacher($teacher);
            $publicChallenge->setRole('ROLE_PUBLIC_CHALLENGE');
            $publicChallenge->setDuration('1heure');
            $publicChallenge->setName($faker->userName);
            $publicChallenge->setDifficulty('medium');
            $publicChallenge->setCreatedAt($faker->dateTime);
            $publicChallenge->setDescription($faker->realText(150));
            $publicChallenge->setNameCorrection('dixfi_5.png');
            $publicChallenge->setSolutionPath('/solution/dixfi_5.png');

            $manager->persist($publicChallenge);
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
