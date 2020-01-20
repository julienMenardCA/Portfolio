<?php 

//ce fichier reçoit toutes les requêtes au site

//on instancie notre contrôleur où sont toutes nos méthodes
//pour chaque page
//on inclue d'abord la définition de la classe
include("Controller.php");

$controller = new Controller();

//si on n'a pas de paramètre dans l'URL... c'est l'accueil
if (empty($_GET['page']) || $_GET['page'] == "accueil")
{
    $controller->home();
}
if($_GET['page'] == 'mentions')
{
    $controller->mentions();
}
//Si la nom de la page n'est pas reconnue => 404
else 
{
    $controller->fourOfour();
}

?>