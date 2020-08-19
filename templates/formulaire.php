<!-- Formulaire de contact et/ou d'ajout de recommandation -->
<div class="formulaire">
        <form method="post">
            <div class="row">
                <div class="col">
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
                <div class="col">
                    <div class="form-group">
                        <label for="content">Contenu de votre message</label>
                        <textarea name="content" id="content" rows="7" cols="50" required maxlength="500"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="cgu-read">J'ai lu et compris les <a href="index.php?page=cgu">Conditions Générales d'Utilisation</a></label>
                        <input type="checkbox" id="cgu-read" name="cgu-read">
                    </div>

                    <?php
                    //affiche les éventuelles erreurs de validations
                    if (!empty($errors)) {
                        echo '<div class="alert alert-danger">';
                        foreach ($errors as $error) {
                            echo '<div>' . $error . '</div>';
                        }
                        echo '</div>';
                    }
                    if((isset($messageState) && $messageState === true) || (isset($recoSent) && $recoSent === true))
                    {
                        $whereAreWe = "";
                        if($_GET['page'] == 'contact')
                        {
                            $whereAreWe = "Message";
                        }
                        elseif($_GET['page'] == 'ajout-recommandation')
                        {
                            $whereAreWe = "Recommandation";
                        }
                        echo '<div class="alert alert-success">';
                        echo '<div>' . 'Votre '.$whereAreWe.' à bien été envoyé' . '</div>';
                        echo '</div>';
                    }
                    elseif(isset($messageState) && $messageState !== true && $messageState !== false)
                    {
                        echo '<div class="alert alert-danger">';
                        echo '<div>' . $messageState . '</div>';
                        echo '</div>';
                    }
                    ?>
                    <div class="g-recaptcha form-group" data-sitekey="6LeQTdoUAAAAAIw1VH9kNj4IvWRnWX1tFlkK-7iS"></div>

                    <button class="btn btn-primary">Envoyer !</button>
                </div>
            </div>


        </form>
    </div>