<?php


namespace App\DataFixtures;


use App\Entity\UserGuest;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;


class UserGuestFixtures extends Fixture
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
            $userGuest = new UserGuest();
            $userGuest->setMail($faker->email);
            $userGuest->setRoles(['ROLE_USER_GUEST']);
            $userGuest->setPassword($this->encoder->encodePassword($userGuest, 'Azerty'));
            $userGuest->setName($faker->lastName);
            $userGuest->setFirstname($faker->firstName);
            $userGuest->setNickname($faker->userName);
            $manager->persist($userGuest);
            $this->addReference('teacher_'. $nbTeacher, $userGuest);
        }

        $manager->flush();
    }

}