<?php

namespace App\Service;

use App\Repository\HelpRepository;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotConversation extends Conversation
{
    protected string $idChallenge;

    public function askIdChallenge()
    {
        $this->ask('Quelle est le numéro du défi ?', function (Answer $answer) {
            $this->idChallenge = $answer->getText();
            $this->say('Le numéro du défi est le ' . $this->idChallenge);

        });
    }

    public function run()
    {
        $this->askIdChallenge();
    }
}