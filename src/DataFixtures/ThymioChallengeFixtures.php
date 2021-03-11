<?php


namespace App\DataFixtures;


use App\Entity\ThymioChallenge;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ThymioChallengeFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $thymioChallenges = [
            1 => [
                'name' => 'Bonjour de Thymio',
                'difficulty' => 'Easy',
                'description' => "Thymio a sa façon de dire bonjour. Quand vous appuyez sur son bouton central, alors Thymio tourne trois fois sur lui-même, puis joue un son de 100 HZ pendant 3 secondes. A votre tour de lui faire dire bonjour à l'aide de Scratch !",
                'duration' => '30min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_1.png'
            ],
            2 => [
                'name' => "Thymio l'explorateur",
                'difficulty' => 'Easy',
                'description' => "QUAND on appuie sur le bouton du milieu, ALORS Thymio avance, QUAND il rencontre un obstacle ALORS il tourne à 45 degrés, et après avoir rencontré 3 obstacles il s’arrête et s'allume en vert.",
                'duration' => '30min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_2.png'
            ],
            3 => [
                'name' => 'Thymio, le robot vigilant',
                'difficulty' => 'Easy',
                'description' =>"QUAND on appuie sur le bouton du centre, ALORS Thymio devient très vigilant. QUAND Thymio rencontre un obstacle, ALORS il s’arrête. QUAND Thymio rencontre le vide, ALORS il change de direction. Piste : Thymio peut considérer qu’il y a du vide devant lui si l’un de ses capteurs au sol est inférieur à 500.",
                'duration' => '30min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_3.png'
            ],
            4 => [
                'name' => 'Test',
                'difficulty' => 'Easy',
                'description' => "testtesttest",
                'duration' => '30min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_3.png'
            ],
            5 => [
                'name' => 'Thymio, un musicien ambulant !',
                'difficulty' => 'Medium',
                'description' => "QUAND Thymio détecte quelque chose devant lui (sur ses 5 capteurs avants) ALORS il change de couleur, joue un son et tourne de 45 degré S’IL détecte quelque chose à gauche.
QUAND Thymio détecte quelque chose devant lui (sur ses 5 capteurs avants) ALORS il change de couleur, joue un son et tourne de -45 degré S’IL détecte quelque chose à droite.",
                'duration' => '45min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_5.png'
            ],
            6 => [
                'name' => 'Les formes avec Thymio',
                'difficulty' => 'Medium',
                'description' => "Pour ce robot, 
QUAND Thymio détecte quelque chose devant lui (sur ses 5 capteurs avants) ALORS il change de couleur, joue un son et tourne de 45 degré S’IL détecte quelque chose à gauche.
QUAND Thymio détecte quelque chose devant lui (sur ses 5 capteurs avants) ALORS il change de couleur, joue un son et tourne de -45 degré S’IL détecte quelque chose à droite",
                'duration' => '45min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_6.png'
            ],
            7 => [
                'name' => 'La maison de Thymio',
                'difficulty' => 'Medium',
                'description' => "QUAND on appuie sur le bouton du centre, ALORS Thymio dessine une maison constituée d’un carré et d’un triangle pour le toit. Attention, il ne doit pas passer deux fois sur le même trait !",
                'duration' => '45min',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_7.png'
            ],
            8 => [
                'name' => 'La maison de Thymio',
                'difficulty' => 'Hard',
                'description' => "Thymio doit construire sa propre maison. Cependant, il doit faire cela uniquement avec un trait, sans passer deux fois sur le même trait. ",
                'duration' => '1h00',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_8.png'
            ],
            9 => [
                'name' => 'La chorégraphie de Thymio',
                'difficulty' => 'Hard',
                'description' => "QUAND on appuie sur les boutons de directions de Thymio, ALORS les directions sont enregistrées,
QUAND on appuie sur le bouton du milieu, ALORS Thymio fait les mouvements demandes.",
                'duration' => '1h00',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_9.png'
            ],
            10 => [
                'name' => 'Le radar Thymio',
                'difficulty' => 'Extreme',
                'description' => "QUAND on appuie sur le bouton du milieu, ALORS Thymio se met en mode scan et s’allume en vert.
QUAND un objet passe devant son capteur droit, ALORS il s’allume en orange le temps de calculer sa vitesse.
QUAND sa vitesse est trop élevée, ALORS il s’allume en rouge et poursuit l’objet",
                'duration' => '1h30',
                'role' => 'ROLE_THYMIO',
                'solutionPath'=> '/solution/dixfi_10.png'
            ],
        ];

        foreach($thymioChallenges as $key => $value){
            $thymioChallenge = new ThymioChallenge();
            $thymioChallenge->setName($value['name']);
            $thymioChallenge->setDifficulty($value['difficulty']);
            $thymioChallenge->setRole($value['role']);
            $thymioChallenge->setDescription($value['description']);
            $thymioChallenge->setDuration($value['duration']);
            $thymioChallenge->setSolutionPath($value['solutionPath']);
            $manager->persist($thymioChallenge);

            $this->addReference('thymioChallenge_'. $key, $thymioChallenge);

        }

        $manager->flush();
    }
}
