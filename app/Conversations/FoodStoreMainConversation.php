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
    protected $name;
    protected $items;
    protected $address;
    protected $phoneNumber;

    public function __construct() {
        $this->name = "";
        $this->items = [];
        $this->address = "";
        $this->phoneNumber = "";
    }

    public function askName() {
        $this->ask('Hello! What is your name?', function(Answer $answer){
            $this->name = $answer->getText();
            $this->say('Nice to meet you ' . $this->name);
            $this->askServices();
        });
    }

    public function askServices() {
        $question = Question::create("Please choose services available below")
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
                $choosenItem = Item::find($answer->getValue());
                array_push($this->items, $choosenItem);

                $this->say("you choose food with id : " . $answer->getValue());
                $this->ask("do you want to choose another food ? (yes/no)", function(Answer $answer) {
                    if ($answer->getText() === 'yes') {
                        $this->askFoodCategories();
                    } else {
                        $this->askAddress();
                    }
                });
            }
        });
    }

    public function askAddress() {
        $this->ask('what is your address ?', function(Answer $answer){
            $this->address = $answer->getText();
            $this->askPhoneNumber();
        });
    }

    public function askPhoneNumber() {
        $this->ask('what is your phone number ?', function(Answer $answer){
            $this->phoneNumber = $answer->getText();
            $this->askSummary();
        });
    }

    public function askSummary() {
        $itemsTextBody = "";
        $subtotal = 0;


        foreach ($this->items as $item) {
            $subtotal += $item->sale_price;
            $itemsTextBody .= sprintf(
                        "ID    : %s\n" .
                        "Name  : %s\n" .
                        "Price : Rp %.2f\n",
                        $item->id, $item->name, $item->sale_price);
        }

        $summaryText = sprintf(
                        "--Summary--\n\n" .
                        "--Customer Info--\n" .
                        "Name        : %s\n" .
                        "Address     : %s\n" .
                        "Phone Number: %s\n\n" .
                        "--Items--\n" .
                        "%s\n" .
                        "Subtotal  : Rp %.2f\n" .
                        "Status    : UNPAID\n\n\n" .
                        "do you want to proceed (yes/no) ?",
                        $this->name, $this->address, $this->phoneNumber,
                        $itemsTextBody, $subtotal
                        );


        $this->ask($summaryText, function(Answer $answer){
            if ($answer->getText() === "yes") {
                $this->say("These items will be delivered to your address, please provide payment accordingly");
            } else {
                $this->askServices();
            }
        });
    }

    public function run() {
        $this->askName();
    }
}
