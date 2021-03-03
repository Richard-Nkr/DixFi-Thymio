<?php


namespace App\Service;


use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class BotConversation extends Conversation
{
    public function askHelp()
    {
        $question = Question::create('Do you need a clue?')
            ->addButtons([
                Button::create('Of course')->value('yes'),
                Button::create('Hell no!')->value('no'),
            ]);
        $this->ask($question, function (Answer $answer) {
            // Detect if button was clicked:
            if ($answer->isInteractiveMessageReply()) {
                $selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                $selectedText = $answer->getText(); // will be either 'Of course' or 'Hell no!'
            }
        });

    }

    public function run()
    {
        $this->askHelp();
    }
}