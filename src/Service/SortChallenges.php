<?php

namespace App\Service;



class SortChallenges
{
    public function sort(array $statusList) : int
    {
        $count = 0;
        foreach($statusList as $status){
            $challenge=$status->getChallenge();
            if ($challenge->getRole()=="ROLE_THYMIO"){
                if($challenge->getDifficulty()=="Easy"){
                    $count=$count+1;
                }
            }
        }
        if ($count==4){
            foreach($statusList as $status){
                $challenge=$status->getChallenge();
                if ($challenge->getRole()=="ROLE_THYMIO"){
                    if($challenge->getDifficulty()=="Medium"){
                        $count+=1;
                    }
                }
            }
        }
        if ($count==7){
            foreach($statusList as $status){
                $challenge=$status->getChallenge();
                if ($challenge->getRole()=="ROLE_THYMIO"){
                    if($challenge->getDifficulty()=="Hard"){
                        $count+=1;
                    }
                }
            }
        }
        return $count;
    }
}
