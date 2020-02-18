<?php 
//J'utilise "dirname(__FILE__)" ici pour pouvoir utilisé un chemin relatif
include(dirname(__FILE__)."/../../templates/top.php");?>
<!-- Page Admin -->
<main class="add-post">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group"> 
            <label for="title">Titre</label>
            <input class="form-control" type="text" name="title" id="title" value="<?php if(!empty($_POST['title'])){echo $_POST['title'];} ?>" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" rows="5" id="description" name="description" required maxlength="500"><?php if(!empty($_POST['description'])){echo $_POST['description'];} ?></textarea>
        </div>
        <div class="form-group">
            <label for="github">Lien Github</label>
            <input class="form-control" type="text" name="github" id="github" value="<?php if(!empty($_POST['github'])){echo $_POST['github'];} ?>" required>
        </div>
        <div class="form-group">
            <label for="web-link">Lien web</label>
            <input class="form-control" type="text" name="web-link" id="web-link" value="<?php if(!empty($_POST['web-link'])){echo $_POST['web-link'];} ?>" required>
        </div>
        <div class="form-group">
            <label for="pic">Choisir une image à téléverser :</label>
            <input type="file" name="pic" id="pic">
        </div>

        <button class="btn btn-primary">Envoyer !</button>
    </form>

    <?php 
        //affiche les éventuelles erreurs de validations
        if (!empty($errors)) {
            echo '<div class="alert alert-danger">';
            foreach ($errors as $error) {
                echo '<div>' . $error . '</div>'    ;
            }
            echo '</div>';
        }   
    ?>
</main>

<?php include(dirname(__FILE__)."/../../templates/bottom.php") ?>