<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('Hi', function ($bot) {
    $bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');

//fallback when no command specified
$botman->fallback(function($bot){
	$bot->reply('Welcome to the food store chatbot! please type "start" to start using this application');
});

$botman->hears('start', BotManController::class.'@startMainConversation');

