<?php 
//on inclue ici toutes nos classes ! 
spl_autoload_register();

//rend disponible toutes nos dépendances chargées par composer
include("vendor/autoload.php");

//paramètres de connexion en constantes
//soit localhost, soit l'IP du serveur
define("DBHOST", "localhost");
//utilisateur de la base (différent de PHPmyAdmin)  
define("DBUSER", "root");
//mot de passe
define("DBPASS", "");           
//nom de la base de données
define("DBNAME", "portfolio");

//on utilise les sessions dans ce site, alors on prévient PHP
session_start();

//on est dans le contrôleur frontal \o/
//ce fichier reçoit toutes les requêtes au site

//on instancie notre contrôleur où sont toutes nos méthodes
//pour chaque page
//on inclue d'abord la définition de la classe
$controller = new Controller();

//si on n'a pas de paramètre dans l'URL... c'est l'accueil
if (empty($_GET['page']) || $_GET['page'] == "accueil")
{
    $controller->home();
}
elseif($_GET['page'] == "mentions")
{
    $controller->mentions();
}
elseif($_GET['page'] == "contact")
{
    $controller->contact();
}
elseif($_GET['page'] == "cv")
{
    $controller->cv();
}
elseif($_GET['page'] == "ajout-recommandation")
{
    $controller->addRecommandations();
}
elseif($_GET['page'] == "toutes-recommandation")
{
    $controller->allRecommandations();
}
elseif($_GET['page'] == "itslogintime")
{
    $controller->adminLogin();
}
elseif($_GET['page'] == "itsadmintime")
{
    $controller->adminPage();
}
elseif($_GET['page'] == "itsdecotime")
{
    $controller->adminLogOff();
}
elseif($_GET['page'] == "detail-projet")
{
    $controller->workDetails();
}
//Si la nom de la page n'est pas reconnue => 404
else 
{
    $controller->fourOfour();
}

?>