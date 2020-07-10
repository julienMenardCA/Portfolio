<?php
//on inclue ici toutes nos classes ! 
//spl_autoload_register();

include("Controller.php");

//on utilise les sessions dans ce site, alors on prévient PHP
session_start();

//on instancie notre contrôleur où sont toutes nos méthodes
//pour chaque page
//on inclue d'abord la définition de la classe
$controller = new Controller();

if(empty($_GET['action']))
{
    $controller->firstEntry();
}
else
{
    if($_GET['action'] == 'play')
    {
        if(empty($_GET['turn']) || $_GET['turn'] == '1')
        {
            $controller->firstTurn();
        }
    }
    elseif($_GET['action'] == 'new-game')
    {
        $controller->newGame();
    }
    elseif($_GET['action'] === 'add-card')
    {
        $controller->addCard();
    }
    elseif($_GET['action'] === 'stop')
    {
        $controller->stop();
    }
    elseif($_GET['action'] === 'bet')
    {
        $controller->bet();
    }
    elseif($_GET['action'] === 'end')
    {
        $controller->end();
    }
    elseif($_GET['action'] === 'bankrupt')
    {
        $controller->bankrupt();
    }
}
?>