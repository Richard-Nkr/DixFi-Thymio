<?php

namespace App\DataFixtures;

use App\Entity\Chat;
use App\Entity\Teacher;
use App\Entity\Users;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class TeacherFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbTeacher = 2; $nbTeacher <= 10; $nbTeacher++){
            $teacher = new Teacher();
            $teacher->setMail($faker->email);
            $teacher->setRoles(['ROLE_TEACHER']);
            $teacher->setPassword($this->encoder->encodePassword($teacher, 'Azerty'));
            $teacher->setName($faker->lastName);
            $teacher->setFirstname($faker->firstName);
            $teacher->setNickname($faker->userName);
            $teacher->setProgression($faker->boolean);
            $manager->persist($teacher);
            $chat = new Chat();
            $chat->setTeacher($teacher);
            $teacher->setChat($chat);
            $manager->persist($chat);
            $manager->flush();


            $this->addReference('teacher_'. $nbTeacher, $teacher);
        }

        $manager->flush();
    }
}