<?php include("templates/top.php");?>

<?php 
    $nbrTurn = $_GET['turn'];

    //Choisis une couleur aléatoire pour la couleur du dos des cartes
    $deckBacks = ["yellow", "gray", "green", "purple", "red", "blue",];
    if(empty($_SESSION['cards']['deck-color']))
    {
        $deckColor = $deckBacks[rand(0, 5)];
        $_SESSION['cards']['deck-color'] = $deckColor;
    }

    //Si le joueur fait plus de 21, c'est perdu
    if($_SESSION['game']['player'] > 21)
    {
        $_SESSION['game']['state'] = "<p>PERDU !!!</p>Vos points dépassent 21 !";
    }
    //Si 21 dès le premier tour pour le joueur, blackjack
    elseif($_SESSION['game']['player'] == 21 && $_GET['turn'] == 1 && $_SESSION['game']['bet'] === true)
    {
        $_SESSION['game']['state'] = "<p>GAGNÉ !!!</p>Vous avez fait un blackjack !<p>Vous remportez 12,50€ !";
        $_SESSION['bank']['money'] += 12.5;
    }

    //Si le joueur s'arrête, soit le croupier tire une carte, soit c'est la fin de partie et on affiche les résultats
    if($_GET['action'] === 'stop')
    {   
        if($_SESSION['game']['croupier'] < $_SESSION['game']['player'] && $_SESSION['game']['croupier'] < 17)
        {
            header("Location: index.php?action=stop&turn=".($nbrTurn+1));
            die();
        }
        else
        {
            header("Location: index.php?action=end&turn=".($nbrTurn));
            die();
        }
    }
    
    //Soit le deck est un lien qui ajoute une carte une joueur, soit une simple image non clickable
    $currentDeckBack = '<img class="cards" src="cards/'.$_SESSION['cards']['deck-color'].'_back.png">';
    if(empty($_SESSION['game']['state']) && $_GET['action'] !== 'stop' && $_SESSION['game']['bet'] === true && $_GET['action'] !== 'end')
    {
        $stateOfDeck = '<a href="index.php?action=add-card&turn='.($nbrTurn+1).'">'.$currentDeckBack.'</a>';
    }
    else
    {
        $stateOfDeck = $currentDeckBack;
    }
?>

<main>
<div class="jeu-de-cartes">
    <div class="deck">
        <h2>Deck de cartes&nbsp;:</h2>
        <?= $stateOfDeck?>
        <?php 
        //La plupart de ce genre de IF de ce programme sont pour afficher ou non des parties de la page selon ou on en ait dans le jeu
        if($_SESSION['game']['bet'] === true)
        {?>
            <p>Cliquez le deck pour<br>piocher une nouvelle carte</p>
        <?php }
        ?>
        <?php 
            if(empty($_SESSION['game']['state']) && $_GET['action'] !== 'stop' && $_SESSION['game']['bet'] === true)
            {?>
                <form action="index.php?action=new-game" method="post" class="new-game-button">
                    <input type="submit" value="Nouveau jeu">
                </form>
            <?php }?>
        <div class="money">
            <h3>Votre argent : <?=$_SESSION['bank']['money']?>€</h3>
            <?php 
                if($_GET['turn'] === '1' && $_SESSION['game']['bet'] === false)
                {
                    if(!array_key_exists('warning', $_SESSION['bank']) || empty($_SESSION['bank']['warning']))
                    {?>
                    <form action="index.php?action=bet&turn=1" method="post">
                        <input type="submit" value="Miser 5€">
                    </form>
                    <?php }
                    else
                    {?>
                    <form action="index.php?action=bankrupt&turn=1" method="post">
                        <input type="submit" value="Demander de l'argent à la Banque de France">
                    </form>
                    <?php }
                }
                if($_SESSION['game']['bet'] === true && (!array_key_exists('warning', $_SESSION['bank']) || empty($_SESSION['bank']['warning'])))
                {?>
                    <p>Vous avez misé 5€</p>
                <?php }
                elseif(array_key_exists('warning', $_SESSION['bank']) && !empty($_SESSION['bank']['warning']))
                {?>
                    <p><?=$_SESSION['bank']['warning']?></p>
                <?php }?>
        </div>
    </div>
    <?php 
        if($_SESSION['game']['bet'] === true)
        {?>
        <div>
        <div class="croupier">
            <h2>Jeu du croupier : <?= $_SESSION['game']['croupier']?></h2>
            <?php 
            foreach ($_SESSION['cards']['croupier'] as $carteCroupier) 
            {?>
                <img class="cards" src="cards/<?=$carteCroupier?>.png">
            <?php if($_GET['action'] !== 'stop'  && $_GET['action'] !== 'end')
                    {
                        echo $currentDeckBack;
                    }
            }
            ?>
        </div>
        <div class="state-of-game">
            <?php 
                if(!empty($_SESSION['game']['state']))
                {
                    echo $_SESSION['game']['state'];?>
                    <form action="index.php?action=new-game" method="post" class="new-game-button">
                        <input type="submit" value="Nouvelle partie">
                    </form>
                <?php }
            ?>
        </div>
        <h2>Votre jeu : <?= $_SESSION['game']['player']?></h2>
        <?php 
        foreach ($_SESSION['cards']['joueur'] as $carteJoueur) 
        {?>
            <img class="cards" src="cards/<?=$carteJoueur?>.png">
        <?php }
        ?>
        <br>
        <?php 
            if(empty($_SESSION['game']['state']) && $_GET['action'] !== 'stop'  && $_GET['action'] !== 'end')
            {?>
                <form action="index.php?action=stop&turn=<?=$nbrTurn+1?>" method="post">
                    <input type="submit" value="Arrêter ici">
                </form>
            <?php }?>
    </div>
        <?php }
    ?>
</div>
</main>

<?php include("templates/bottom.php");?>