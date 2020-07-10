<?php
Class Controller
{
    private $bankMoney = 50;

    /*
    Cette méthode cacule les points carte par carte, et pour la valeur de l'as, regarde les points totaux du deck qui appele cette méthode
    */
    private function calculatePoints($card, $whatDeck)
    {
        $cardsPoints = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11,];

        $valueCard = 0;

        for ($i=0; $i < sizeof($cardsPoints); $i++) 
        {
            if(strpos($card, "C") !== false)
            {
                $cardFamily = "C";
            }
            elseif (strpos($card, "S") !== false) 
            {
                $cardFamily = "S";
            }
            elseif (strpos($card, "H") !== false) 
            {
                $cardFamily = "H";
            }
            elseif (strpos($card, "D") !== false) 
            {
                $cardFamily = "D";
            }

            $newCard = explode($cardFamily, $card);
            if((int)$newCard[0] == $cardsPoints[$i])
            {
                $valueCard += (int)$cardsPoints[$i];
            }
        }
        if($newCard[0] === 'Q' || $newCard[0] === 'K' || $newCard[0] === 'J')
        {
            $valueCard += 10;
        }
        //AS, 1 ou 11 ? :thinking:
        if($newCard[0] === 'A')
        {
            if($_SESSION['game'][$whatDeck] <= 10)
            {
                if(rand(0, 1) == 0)
                {
                    $valueCard += 1;
                }
                else
                {
                    $valueCard += 11;
                }
            }
            else
            {
                $valueCard += 1;
            }
        }

        return $valueCard;
    }

    //Pour la première entrée sur le site, initialise les valeur que je veux garder dans la session
    public function firstEntry()
    {
        $_SESSION['bank']['money'] = $this->bankMoney;
        $_SESSION['bank']['game'] = 1;

        $_SESSION['game']['firstEntry'] = true;

        header("Location: index.php?action=play&turn=1");
    }

    //Pour le 1er tour de chaque parties
    public function firstTurn()
    {
        include("game.php");

        $_SESSION['cards']['deck'] = $deck;
        $_SESSION['cards']['deck-color'] = null;

        $_SESSION['game']['calculated'] = false;

        $_SESSION['game']['player'] = 0;
        $_SESSION['game']['croupier'] = 0;
        $_SESSION['game']['bet'] = false;

        shuffle($_SESSION['cards']['deck']);

        $_SESSION['cards']['croupier'] = [];

        $_SESSION['cards']['joueur'] = [];

        array_pop($_SESSION['cards']['deck']);

        //Distribue les 2 premières cartes du joueur
        for ($i=0; $i < 2; $i++) { 
            $_SESSION['cards']['joueur'][] = $_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1];
            array_pop($_SESSION['cards']['deck']);
        }

        //Calcule les points des deux cartes du joueur
        foreach($_SESSION['cards']['joueur'] as $card)
        {
            $_SESSION['game']['player'] += $this->calculatePoints($card, 'player');
        }

        //Distribue et calcule la valeur de la 1ère carte du croupier
        $_SESSION['cards']['croupier'][] = $_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1];
        $_SESSION['game']['croupier'] += $this->calculatePoints($_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1], 'croupier');
        array_pop($_SESSION['cards']['deck']);

        //Direction la table de jeu
        include("templates/blackjack.php");
    }

    //Ajoute une carte pour le joueur, et ajoute la valeur de cette carte à ses points
    public function addCard()
    {
        $_SESSION['cards']['joueur'][] = $_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1];
        $_SESSION['game']['player'] += $this->calculatePoints($_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1], 'player');
        array_pop($_SESSION['cards']['deck']);

        include("templates/blackjack.php");
    }

    //Quand le joueur décide de s'arrêter, cette methode est appellé répétitivement jusqu'à ce que le croupier s'arrête
    public function stop()
    {
        $_SESSION['cards']['croupier'][] = $_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1];
        $_SESSION['game']['croupier'] += $this->calculatePoints($_SESSION['cards']['deck'][sizeof($_SESSION['cards']['deck'])-1], 'croupier');
        array_pop($_SESSION['cards']['deck']);

        include("templates/blackjack.php");
    }

    //Quand le croupier s'arrête, cette méthode est appellé et vérifie qui a gagné et comment
    public function end()
    {
        if($_SESSION['game']['croupier'] === 21 && $_SESSION['game']['player'] < 21)
        {
            $_SESSION['game']['state'] = '<p>PERDU !!!</p>Le croupier a fait 21 et vous, non !';
        }
        elseif($_SESSION['game']['croupier'] > $_SESSION['game']['player'] && $_SESSION['game']['croupier'] < 22 )
        {
            $_SESSION['game']['state'] = '<p>PERDU !!!</p>Le croupier a un meilleur jeu que vous !';
        }
        elseif($_SESSION['game']['croupier'] == $_SESSION['game']['player'])
        {
            $_SESSION['game']['state'] = '<p>ÉGALITÉ !!!</p>Vous récupérez votre mise de 5€.';
            $_SESSION['bank']['money'] += 5;
        }
        elseif($_SESSION['game']['croupier'] > $_SESSION['game']['player'] || $_SESSION['game']['croupier'] < $_SESSION['game']['player'])
        {
            $_SESSION['game']['state'] = '<p>GAGNÉ !!!</p>Le croupier a un pire jeu que vous !<p>Vous remportez 10€</p>';
            $_SESSION['bank']['money'] += 10;
        }

        include("templates/blackjack.php");
    }

    //En fin de partie, quand le joueur veut faire une nouvelle, les deux champs non nécessaire sont vidé
    public function newGame()
    {
        $_SESSION['cards'] = null;
        $_SESSION['game'] = null;

        //Incrémente une valeur pour l'instant non utilisé
        $_SESSION['bank']['game'] ++;

        header("Location: index.php?action=play&turn=1");
    }

    //Quand le joueur mise 5€
    public function bet()
    {
        if($_SESSION['bank']['money'] >= 5)
        {
            $_SESSION['bank']['money'] -= 5;
            //Sert à savoir quoi affiché
            $_SESSION['game']['bet'] = true;
        }
        else
        {
            $_SESSION['bank']['warning'] = "Vous n'avez plus d'argent";
        }

        include("templates/blackjack.php");
    }

    public function bankrupt()
    {
        $_SESSION['bank']['money'] = $this->bankMoney;
        $_SESSION['bank']['warning'] = null;
        session_unset($_SESSION['bank']['warning']);

        header("Location: index.php");
    }
    
}
?>