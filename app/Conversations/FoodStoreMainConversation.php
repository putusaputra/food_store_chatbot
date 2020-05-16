<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Question;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use App\Category;
use App\Item;

class FoodStoreMainConversation extends Conversation
{
    protected $firstname;

    public function askServices() {
        $question = Question::create("Choose services")
            ->fallback('Unable to ask question')
            ->callbackId('ask_services')
            ->addButtons([
                Button::create('food store')->value('food_store'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'food_store') {
                    $this->askFoodCategories();
                } else {
                    $this->say('nothing found');
                }
            }
        });
    }

    public function askFoodCategories() {
        $categories = Category::all();
        $buttons = array();
        foreach ($categories as $cat) {
            array_push($buttons, Button::create($cat->name)->value($cat->id));
        }

        $question = Question::create("Choose food categories")
            ->fallback('Unable to ask question')
            ->callbackId('ask_food_categories')
            ->addButtons($buttons);
        
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                // if ($answer->getValue() === 'food_store') {
                //     $this->askFoodCategories();
                // } else {
                //     $this->say('nothing found');
                // }
                //dd($answer);
                $this->say("you choose food category with id : " . $answer->getValue());

                $this->askFoodNameAndPrice($answer->getValue());
            }
        });
    }

    public function askFoodNameAndPrice($categories_id) {
        $items = Item::where('categories_id', $categories_id)->get();
        $buttons = array();
        foreach ($items as $item) {
            $buttonText = sprintf('%s%sRp %s', $item->name, PHP_EOL,
                number_format($item->sale_price, 0, ',', '.'));
            array_push($buttons, Button::create($buttonText)->value($item->id));
        }

        $question = Question::create("Choose foods")
            ->fallback('Unable to ask question')
            ->callbackId('ask_food_name_and_price')
            ->addButtons($buttons);
        
        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                // if ($answer->getValue() === 'food_store') {
                //     $this->askFoodCategories();
                // } else {
                //     $this->say('nothing found');
                // }
                //dd($answer);
                $this->say("you choose food with id : " . $answer->getValue());
                $this->ask("do you want to choose another food ? (yes/no)", function(Answer $answer) {
                    if ($answer->getText() === 'yes') {
                        $this->askFoodCategories();
                    } else {
                        $this->say("this is how much you need to pay");
                    }
                });
            }
        });
    }

    public function run() {
        // This will be called immediately
        $this->askServices();
    }
}
