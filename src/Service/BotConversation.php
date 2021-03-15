<?php


namespace App\Service;



use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class BotConversation extends Conversation
{

    protected $firstname;
    protected $selectedValue;
    protected $selectedText;

    public function askName()
    {
        $this->say("Je suis là pour t'aider. Faisons connaissance");
        $this->ask("Comment t'appelles-tu?", function (Answer $answer) {
            $this->firstname = $answer->getText();
            $this->say('Très joli nom '.$this->firstname);
            $this->askHelp();
        });

    }


    public function askHelp(){
        $question = Question::create('Je te propose d\'appuyer sur le bouton qui concerne ta question.')
            ->addButtons([
                Button::create('Qui es-tu Thymio?')->value('thymio'),
                Button::create('La programmation c\'est quoi?')->value('programmation'),
                Button::create('Comment programmer les défis de ce site?')->value('Scratch, suite Thymio'),
            ]);


        $this->ask("Alors ".$this->firstname.", tu es ici pour avoir mon aide, n'est-ce pas?(oui/non)", function (Answer $answer) use ($question) {
            if ($answer->getText()=="oui"){
                $this->ask($question,function(Answer $answer){
                    if ($answer->isInteractiveMessageReply()) {
                        $this->selectedValue = $answer->getValue(); // will be either 'yes' or 'no'
                        $this->selectedText = $answer->getText();

                        if ($this->selectedValue=="thymio"){
                            $attachment="https://www.thymio.org/fr/";
                            $this->say("OK je comprends ta question. Voici mon lien préféré à ce sujet : <a href=".$attachment." target='_blank'> https://www.thymio.org/fr/ </a> ");
                        }
                        else if ($this->selectedValue=="programmation"){
                            $attachment="https://kidiscience.cafe-sciences.org/articles/quest-ce-que-la-programmation/";
                            $this->say("OK je comprends ta question. Voici mon lien préféré à ce sujet : <a href=".$attachment." target='_blank'> https://kidiscience.cafe-sciences.org/articles/quest-ce-que-la-programmation/ </a> ");
                        }
                        else if ($this->selectedValue=="Scratch, suite Thymio"){
                            $attachment="https://www.thymio.org/fr/programmer/ ";
                            $attachment2="https://www.fun-mooc.fr/courses/course-v1:inria+41017+session01/80b8f640c7fe42e98bc0f54dc65c0d50/#:~:text=%20%20%201%20Lancer%20Thymio%20Suite%202,sur%20le%20bouton%20%22Programmer%20avec%20Scratch%22%20More";
                            $this->say("OK je comprends ta question. Voici mes liens préférés à ce sujet : <a href=".$attachment." target='_blank'> https://www.thymio.org/fr/programmer/  </a> <a href=".$attachment2."  target='_blank'> Cliques ici pour avoir plus d'infos sur la manipulation </a>");
                        }
                        $this->ask("J'espère que ce(s) lien(s) répondra/répondront à toutes tes questions. Puis-je encore t'aider ?(oui/non)",function (Answer $answer){
                            if($answer->getText()=="oui"){
                                $this->askHelp();
                            }
                            else{
                                $this->askJoke();
                            }
                        });
                    }
                });
            }
            else{
                $this->askJoke();
            }
        });


    }

    public function askJoke(){
        $this->ask("Dans ce cas-là, je peux te raconter une petite blague afin d'embellir ta journée?(oui/non)",function (Answer $answer){
            if($answer->getText()=="oui"){
                $this->ask("Quelle est la différence entre un robot et du ketchup?",function (Answer $answer){
                    if((strpos($answer->getText(),"automate")!=false) || (strpos($answer->getText(),"automates")!=false) || (strpos($answer->getText(),"aux tomates")!=false) || ($answer->getText() == "automate") || ($answer->getText() == "automates") || ($answer->getText() == "aux tomates")){
                        $this->say("Wooow, tu me surprends. Tu es prêt pour nos défis j\'en suis certain !");
                        $this->say("Alors je te souhaite une très belle journée ".$this->firstname." et amuses-toi bien sur le site ! :-)");
                    }
                    else{
                        $this->say("Aucune, ils sont tous les deux automates. :-)");
                        $this->say("Mon humour est peut-être à revoir.. Promis je m'entraînerai dessus pendant que tu t'amuseras sur le site. Assez discuté ".$this->firstname.", il est temps que je te laisse profiter de cette belle journée, à bientôt !");
                    }
                });
            }
            else{
                $this->say("Alors je te souhaite une très belle journée ".$this->firstname." et amuses-toi bien sur le site ! :-)");
            }
        });
    }

    public function run()
    {
        $this->askName();
    }
}