<?php


namespace App\Service;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use App\Repository\HelpRepository;

class BotConversation extends Conversation
{
    public function askHelp()
    {
        $question = Question::create('As-tu besoin d\'un indice ?')
            ->addButtons([
                Button::create('Oui')->value('yes'),
                Button::create('Non')->value('no'),
            ]);
        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
                if ($selectedValue == 'yes'){
                    $this->askHelp1();
                }
            }
        });

    }

    public function askHelp1(HelpRepository $helpRepository)
    {
        $helpRepository->findByNumberHelp(1);
        $question = Question::create('Veux-tu voir le 1er indice ?')
            ->addButtons([
                Button::create('Oui')->value('yes'),
                Button::create('Non')->value('no'),
            ]);
        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
                if ($selectedValue == 'yes'){
                    $this->say("OK");
                }
            }
        });
    }

    public function run()
    {
        $this->askHelp();
    }
}