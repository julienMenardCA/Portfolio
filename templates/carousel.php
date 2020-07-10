<?php 
//Cette fonction permet de faire un carousel différent correspondant à ce que je veux afficher
//Soit pour les recommandations ou pour les travaux effectués
/**
 * $carouselType : une chaîne de caractères permettant de savoir quel type de carousel à affiché
 * $dataArray : un tableau de données à afficher dans les carousels
 */
function carousel($carouselType, $dataArray)
{
    $id = "";
    $comment = "";
    $img = false;
    $recommandation = false;
    //Pour les travaux
    if($carouselType == 'travaux')
    {
        $id = 'carouselTravaux';
        $characterLimit = 80;
        $img = true;
        $comment = 'description';
    }
    //Pour les recommandations
    elseif($carouselType == 'recommandations')
    {
        $id = 'carouselRecommendations';
        $characterLimit = 250;
        $comment = 'commentaire';
        $recommandation = true;
    }
    ?>
    <div id="<?=$id?>" class="carousel slide" data-ride="carousel">
    <?php //Affiche autant d'indicateurs pour le carousel qu'il y a d'élément dans le tableau
          //reçu en paramètre, maximum 5 (définit dans la requête SQL) ?>
    <ol class="carousel-indicators">
        <?php 
        $nbrRecos = sizeof($dataArray);
        if($nbrRecos > 1)
        {
            for ($i=0; $i < $nbrRecos; $i++) 
            {
                //Rajoute la classe "active" au premier élément des indicateurs (le premier élement affiché)
                $ifFirstCarousel = "";
                if($i == 0)
                {
                    $ifFirstCarousel = ' class="active"';
                }?>
                <li data-target="#<?=$id?>" data-slide-to="<?=$i?>" <?=$ifFirstCarousel?>></li>
            <?php }
        }?>
    </ol>
    <div class="carousel-inner">
        <?php 
        $firstDiapoNbr = $dataArray[0]['id'];
        foreach ($dataArray as $data) 
        {
            //Pareil que pour les indicateurs, mais pour les éléments du carousel
            $firstReco = "";
            if($data['id'] == $firstDiapoNbr)
            {
                $firstReco = 'active';
            }?>
        <div class="carousel-item <?=$firstReco?>">
        <?php 
        if($img)
        {
        //Affiche des images s'il s'agit du carousel des travaux
        //Il s'agit aussi d'un lien pour voir plus en détails ce projet spécifique ?>
        <a href="index.php?page=detail-projet&id=<?=$data["id"]?>"><img class="d-block w-100" src="assets/img/works/<?=$data["image"]?>"></a>
        <?php }
        ?>
        <div class="carousel-caption">
            <?php
            $commentaire = "";
            $tailleChaine = mb_strlen($data[$comment]);
            //Si la taille de la chaîne est plus grande que la limite de caractère indiqué...
            if($tailleChaine > $characterLimit)
            {
                //Divise les commentaires des recommandations ou les descriptions des travaux en plus petit pour en faire
                //des résumés à affiché dans les carousels
                $commentaireReduit = mb_substr($data[$comment], 0, $characterLimit); //Récupère les $characterLimit premiers caractères
                $commentaireExplode = explode(" ", $commentaireReduit); //Enlève les espaces et stock tous les éléments récupérés dans un tableau
                array_pop($commentaireExplode); //Retire le dernier élément du tableau car cela pourrait être un mot coupé par mb_substr
                for ($i=0; $i < sizeof($commentaireExplode)-1; $i++)
                {
                    $commentaire .= $commentaireExplode[$i];
                    if($i < sizeof($commentaireExplode)-2) //-2 Pour être sûr que le boucle passe dans le else
                    {
                        //Remet les espaces entre les mots
                        $commentaire .= " ";
                    }
                    else
                    {
                        //Met [...] à la fin du résumé pour indiquer qu'il y a quelque chose après
                        $commentaire .= "[...]";
                    }
                }
            }
            //Sinon, on affiche simplement ce que l'on a dans la chaîne
            else
            {
                $commentaire = $data[$comment];
            }
            ?>
            <p><?=$commentaire?></p>
            <?php
            //Rajoute une source pour les recommandations (uniquement les recommandations)
            if($recommandation)
            {?>
            <p><?=$data['prenom'].' '.$data['nom'].' le '.$data['date_created']?></p>
            <?php }
            ?>
            </div>
        </div>
        <?php }
        ?>
    </div>
    <?php 
    //On affiche les flèches de navigation du carousel seulement si il y a plus d'un élément
    if($nbrRecos > 1)
    {?>
    <a class="carousel-control-prev" href="#<?=$id?>" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#<?=$id?>" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
    </a>
    <?php }
    ?>
    </div>
    <?php
    //On affiche les bouttons lié aux recommandations seulement si c'est nécessaire
    if($recommandation)
    {?>
    <div class="carousel-buttons">
        <div class="gauche">
            <form action="index.php?page=ajout-recommandation" method="post">
                <button class="btn btn-primary" type="submit">Ajouter une recommandation</button>
            </form>
        </div>
        <div class="droite">
            <form action="index.php?page=toutes-recommandation" method="post">
                <button class="btn btn-primary" type="submit">Voir toutes les recommandations</button>
            </form>
        </div>
    </div>
    <?php }
    ?>
<?php 
} ?>