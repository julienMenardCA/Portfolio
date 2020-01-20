<?php 

Class Controller
{
    public function home()
    {
        include("templates/accueil.php");
    }

    public function mentions()
    {
        include("templates/mentions-legales.php");
    }

    public function fourOfour()
    {
        include("templates/404.php");
    }
}

?>