<?php


namespace App\DataFixtures;



use App\Entity\StudentGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Faker;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class StudentGroupFixtures extends Fixture implements DependentFixtureInterface
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        for($nbStudentGroups = 1; $nbStudentGroups <= 20; $nbStudentGroups++){
            $teacher = $this->getReference('teacher_'. $faker->numberBetween(2, 10));

            $studentGroup = new StudentGroup();
            $studentGroup->setTeacher($teacher);
            $studentGroup->setCountSucceed($faker->numberBetween(0,10));
            $studentGroup->setNickname($faker->userName);
            $studentGroup->setRoles(['ROLE_STUDENT_GROUP']);
            $studentGroup->setPassword($this->encoder->encodePassword($studentGroup, 'Azerty'));

            $this->addReference('studentGroup_'. $nbStudentGroups, $studentGroup);
            $manager->persist($studentGroup);
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