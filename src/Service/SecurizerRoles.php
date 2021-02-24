<?php
namespace App\Service;

use App\Entity\Challenge;
use App\Entity\User;//l'entité user de notre aplication
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Authorization\AccessDecisionManagerInterface;

class SecurizerRoles {

    private $accessDecisionManager;

    public function __construct(AccessDecisionManagerInterface $accessDecisionManager) {
        $this->accessDecisionManager = $accessDecisionManager;
    }

    public function isGranted(User $user, $attribute, $object = null): bool
    {
        $token = new UsernamePasswordToken($user, 'none', 'none', $user->getRoles());
        return ($this->accessDecisionManager->decide($token, [$attribute], $object));
    }

    public function isGrantedChallenge(Challenge $challenge, $attribute, $object = null): bool
    {
        $token = new UsernamePasswordToken($challenge, 'none', 'none', $challenge->getRoles());
        return ($this->accessDecisionManager->decide($token, [$attribute], $object));
    }

}