<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Card
{

    const COLOR1 = 'red';
    const COLOR2 = 'black';

    public $suit;
    public $color;
    public $name;
    public $symbol;
    public $ranking;

    public function __construct($suit = '', $color = '', $name = '')
    {
    }
}

class Player
{

    public $name;
    public $cards = array();

    public function __construct($name = '', $cards = '')
    {
    }
}

abstract class CardDeck
{
    public $deck = array();
    public $total_deck = 0;

    public function shuffle()
    {
        shuffle($this->deck);
    }

    public function drawCard()
    {
        $card = array_shift($this->deck);
        return $card;
    }

    public function getRemainingCardCount()
    {
        return count($this->deck);
    }

    public function getTotalCardCount()
    {
        return $this->total_deck;
    }

    private function totalRankingHelper($item, $key)
    {
        $this->total += $item->ranking;
    }

    public function countTotalRanking()
    {
        $this->total = 0;
        array_walk($this->deck, array('cardDeck', 'totalRankingHelper'));

        return $this->total;
    }
}

class StandardCardDeck extends CardDeck
{
    public  $suits = array('s' => "S", 'h' => "H", 'c' => "C", 'd' => "D");
    private $suitsCards = array('2', '3', '4', '5', '6', '7', '8', '9', 'x', 'j', 'q', 'k', 'a');
    private $namedRanks = array("j" => "J", "q" => "Q", "k" => "K", "a" => "A", "x" => "X");
    private $suitColor = array("S" => Card::COLOR2, "H" => Card::COLOR1, "C" => Card::COLOR2, "D" => Card::COLOR1);
    private $specialCards = array();

    function __construct()
    {
        foreach ($this->suits as $suitAbbrev => $suit) {
            $ranking = 1;
            foreach ($this->suitsCards as $cardnumber) {
                $tempcard = new Card();
                $tempcard->suit = $suit;
                $tempcard->color = $this->suitColor[$suit];
                $tempcard->name =  $suit . '-' . (isset($this->namedRanks[$cardnumber]) ? $this->namedRanks[$cardnumber] : $cardnumber);
                $tempcard->symbol = $cardnumber;
                $tempcard->ranking = $ranking++;

                $this->deck[] = $tempcard;
                $this->total_deck++;
            }
        }

        foreach ($this->specialCards as $abbrev => $name) {
            $tempcard = new Card();
            $tempcard->suit = '';
            $tempcard->color = '';
            $tempcard->name = $name;
            $tempcard->symbol = $abbrev;
            $tempcard->ranking = 0;

            $this->deck[] = $tempcard;
            $this->total_deck++;
        }
    }
}

class GameController
{

    public function index()
    {
        return view('play');
    }

    public function post_game(Request $input)
    {
        $faker = \Faker\Factory::create();

        $players = $input->players;
        if (empty($players) || $players < 0) {
            return redirect(route('game.index'))->with('flash_danger', 'Input value does not exist or value is invalid.');
        }
        $cardDeck = new StandardCardDeck();
        $cardDeck->shuffle();

        $playerWithCards = array();

        for ($i = 0; $i < $players; $i++) {
            $playerWithCards[$i] = new Player();
            $playerWithCards[$i]->name = $faker->name();
        }

        for ($i = 0; $i < $cardDeck->getTotalCardCount(); $i++) {
            foreach ($playerWithCards as $player) {
                if ($cardDeck->getRemainingCardCount() > 0) {
                    array_push($player->cards, $cardDeck->drawCard());
                }
            }
        }

        return view('play_time', compact('playerWithCards'));
    }
}
