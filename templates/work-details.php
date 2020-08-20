<?php include("top.php") ?>
<!-- Page de détail des travaux -->
<main class="work-detail">
    <h2><?=$work['titre']?></h2>
    <img src="assets/img/works/<?=$work['image']?>">
    <br>
    <br>
    <p><?=$work['description']?></p>
    <div id="liens-projet">
        <?php 
            if($work['lien_github'] !== null && $work['lien_github'] !== 'null')
            {?>
                <a href="<?=$work['lien_github']?>" target="_blank">Github</a>
                <br>
            <?php }
            ?>
            <?php 
            if($work['lien_projet'] !== null && $work['lien_projet'] !== 'null')
            {?>
                <a href="<?=$work['lien_projet']?>" target="_blank">Lien vers le projet</a>
                <br>
            <?php }
        ?>
    </div>
    
</main>

<?php include("bottom.php") ?>