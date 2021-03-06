<?php


namespace App\DataFixtures;


use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class UserFixtures
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');
        $user = new User();
        $user->setRoles(['ROLE_ADMIN']);
        $user->setNickname($faker->userName);
        $user->setPassword($this->encoder->encodePassword($user, 'Azerty'));
        $manager->persist($user);
        $manager->flush();
    }
}