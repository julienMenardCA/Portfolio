<div class="formulaire">
        <form method="post">
            <div class="gauche">
                <div class="form-group"> 
                    <label for="lastname">Votre nom</label>
                    <input class="form-control" type="text" name="lastname" id="lastname" required value="<?php if(!empty($_POST['lastname'])) {echo $_POST['lastname'];};?>">
                </div>
                <div class="form-group"> 
                    <label for="firstname">Votre prénom</label>
                    <input class="form-control" type="text" name="firstname" id="firstname" required value="<?php if(!empty($_POST['firstname'])) {echo $_POST['firstname'];};?>">
                </div>
                <div class="form-group"> 
                    <label for="email">Votre email</label>
                    <input class="form-control" type="email" name="email" id="email" required value="<?php if(!empty($_POST['email'])) {echo $_POST['email'];};?>">
                </div>
                <div class="form-group"> 
                    <label for="entreprise">Votre entreprise</label>
                    <input class="form-control" type="text" name="entreprise" id="entreprise" required value="<?php if(!empty($_POST['entreprise'])) {echo $_POST['entreprise'];};?>">
                </div>
                <div class="form-group"> 
                    <label for="location_entreprise">La ville où se situe votre entreprise</label>
                    <input class="form-control" type="text" name="location_entreprise" id="location_entreprise" required value="<?php if(!empty($_POST['location_entreprise'])) {echo $_POST['location_entreprise'];};?>">
                </div>
            </div>
            <div class="droite">
                <div class="form-group">
                    <label for="content">Contenu de votre message</label>
                    <textarea name="content" id="content" rows="8" cols="50" required maxlength="500"></textarea>
                </div>
            
            
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

                <button class="btn btn-primary">Envoyer !</button>
            </div>
        </form>
    </div>