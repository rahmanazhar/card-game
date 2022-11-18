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

abstract class CardDeck
{
    public $deck = array();

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
    public  $suits = array('s' => "Spades", 'h' => "Hearts", 'c' => "Clubs", 'd' => "Diamonds");
    private $suitsCards = array('2', '3', '4', '5', '6', '7', '8', '9', 'x', 'j', 'q', 'k', 'a');
    private $namedRanks = array("j" => "Jack", "q" => "Queen", "k" => "King", "a" => "Ace");
    private $suitColor = array("Spades" => Card::COLOR2, "Hearts" => Card::COLOR1, "Clubs" => Card::COLOR2, "Diamonds" => Card::COLOR1);
    private $specialCards = array();

    function __construct()
    {
        foreach ($this->suits as $suitAbbrev => $suit) {
            $ranking = 1;
            foreach ($this->suitsCards as $cardnumber) {
                $tempcard = new Card();
                $tempcard->suit = $suit;
                $tempcard->color = $this->suitColor[$suit];
                $tempcard->name = (isset($this->namedRanks[$cardnumber]) ? $this->namedRanks[$cardnumber] : $cardnumber) . ' of ' . $suit;
                $tempcard->symbol = $cardnumber;
                $tempcard->ranking = $ranking++;

                $this->deck[] = $tempcard;
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

        $players = $input->players;
        if (empty($players) || $players < 0) {
            return redirect(route('game.index'))->with('flash_danger', 'Input value does not exist or value is invalid.');
        }
        $cardDeck = new StandardCardDeck();
        $cardDeck->shuffle();

        $playerWithCards = array();
        for ($i = 0; $i < $players; $i++) {
            $playerWithCards[$i] = ['cards' => $this->distribute($players, $cardDeck)];
        }


        dd($playerWithCards);
        // return view('play_time', compact('playerWithCards'));
    }

    private function distribute($total_player, $cardDeck)
    {
        $player_get_cards = ($cardDeck->getRemainingCardCount() / $total_player);
        $card_list = array();

        if ($player_get_cards != 0) {
            for ($i = 0; $i < $player_get_cards; $i++) {
                $card_list[$i] = $cardDeck->drawCard();
            }
        }
        // dd($card_list);
        return $card_list;
    }
}
