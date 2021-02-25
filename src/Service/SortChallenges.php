<?php

namespace App\Service;

use App\Entity\Challenge;
use phpDocumentor\Reflection\Types\Array_;

class SortChallenges
{
    public function sort(array $challenges) : int
    {
        $count = 0;
        foreach($challenges as $challenge){
            if ($challenge->getRole()=="ROLE_THYMIO"){
                if($challenge->getDifficulty()=="easy"){
                    $count+=1;
                }
            }
        }
        if ($count==4){
            foreach($challenges as $challenge){
                if ($challenge->getRole()=="ROLE_THYMIO"){
                    if($challenge->getDifficulty()=="medium"){
                        $count+=1;
                    }
                }
            }
        }
        if ($count==7){
            foreach($challenges as $challenge){
                if ($challenge->getRole()=="ROLE_THYMIO"){
                    if($challenge->getDifficulty()=="hard"){
                        $count+=1;
                    }
                }
            }
        }
        return $count;
    }
}
