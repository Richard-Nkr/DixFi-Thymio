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

        for($nbUserGuest = 2; $nbUserGuest <= 10; $nbUserGuest++){
            $userGuest = new UserGuest();
            $userGuest->setMail($faker->email);
            $userGuest->setRoles(['ROLE_USERGUEST']);
            $userGuest->setPassword($this->encoder->encodePassword($userGuest, 'Azerty'));
            $userGuest->setName($faker->lastName);
            $userGuest->setFirstname($faker->firstName);
            $userGuest->setNickname($faker->userName);
            $manager->persist($userGuest);
            $this->addReference('userGuest'. $nbUserGuest, $userGuest);
        }

        $manager->flush();
    }

}