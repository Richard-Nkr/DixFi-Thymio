<?php


namespace App\Service;



use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

class BotSaveConversation extends Conversation
{

    protected $firstname;
    protected $selectedValue;
    protected $selectedText;

    public function saveConversation()
    {
        $this->ask('Je parle très mal français, ma spécialité est le langage de programmation.. On recommence la conversation ?(oui/non)',function (Answer $answer){
            if($answer->getText()=="oui"){
                $this->getBot()->startConversation(new BotConversation);
            }
            else{
                $this->say("Pardon de ne pas avoir compris, je dois rapidement améliorer mon français.. En tout cas je te souhaite une belle journée et amuses-toi bien sur le site. A bientôt !");
            }
        });

    }

    public function run()
    {
        $this->saveConversation();
    }
}