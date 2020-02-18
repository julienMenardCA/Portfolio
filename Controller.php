<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

Class Controller
{
    private $formInfos = [];

    /**
     * Pour la page d'accueil
     */
    public function home()
    {
        $manager = new Manager();
        //Ces deux méthodes sont appellés pour récupérer les données nécessaire aux deux carousels
        $recommandations = $manager->getSomeRecommandations();
        $works = $manager->getSomeWorks();

        include("templates/accueil.php");
    }

    /**
     * Méthode pour vérifier si le formulaire est valide
     */
    private function checkForm()
    {
        $errors = [];

        $lastName = strip_tags($_POST['lastname']);
        $firstName = strip_tags($_POST['firstname']);
        $email = strip_tags($_POST['email']);
        $entreprise = strip_tags($_POST['entreprise']);
        $locationEntreprise = strip_tags($_POST['location_entreprise']);
        $content = strip_tags($_POST['content']);

        $this->formInfos = [
            "lastname" => $lastName,
            "firstname" => $firstName,
            "email" => $email,
            "entreprise" => $entreprise,
            "location_entreprise" => $locationEntreprise,
            "content" => $content,
        ];

        if(empty($lastName))
        {
            $errors[] = "Vous n'avez pas renseigné de nom.";
        }
        elseif(mb_strlen($lastName) == 1)
        {
            $errors[] = "Vous avez renseigné un nom trop court.";
        }
        elseif(mb_strlen($lastName) > 100)
        {
            $errors[] = "Vous avez renseigné un nom trop long.";
        }
        if(empty($firstName))
        {
            $errors[] = "Vous n'avez pas renseigné de prénom.";
        }
        elseif(mb_strlen($firstName) == 1)
        {
            $errors[] = "Vous avez renseigné un prénom trop court.";
        }
        elseif(mb_strlen($firstName) > 100)
        {
            $errors[] = "Vous avez renseigné un prénom trop long.";
        }

        if(empty($email))
        {
            $errors[] = "Vous n'avez pas renseigné d'email.";
        }
        elseif(mb_strlen($email) < 10)
        {
            $errors[] = "Vous avez renseigné un email trop court.";
        }
        elseif(mb_strlen($email) > 100)
        {
            $errors[] = "Vous avez renseigné un email trop long.";
        }

        if(empty($entreprise))
        {
            $errors[] = "Vous n'avez pas renseigné de nom d'entreprise.";
        }
        elseif(mb_strlen($entreprise) < 3)
        {
            $errors[] = "Vous avez renseigné un nom d'entreprise trop court.";
        }
        elseif(mb_strlen($entreprise) > 100)
        {
            $errors[] = "Vous avez renseigné un nom d'entreprise trop long.";
        }

        if(empty($locationEntreprise))
        {
            $errors[] = "Vous n'avez pas renseigné de nom de ville d'entreprise.";
        }
        elseif(mb_strlen($locationEntreprise) < 4)
        {
            $errors[] = "Vous avez renseigné un nom de ville trop court.";
        }
        elseif(mb_strlen($locationEntreprise) > 100)
        {
            $errors[] = "Vous avez renseigné un nom de ville trop long.";
        }

        if(empty($content))
        {
            $errors[] = "Vous avez laissé le champ de message vide.";
        }
        elseif(mb_strlen($content) < 5)
        {
            $errors[] = "Vous avez renseigné un message trop court.";
        }
        elseif(mb_strlen($content) > 500)
        {
            $errors[] = "Vous avez renseigné un message trop long.";
        }
        
        return $errors;
    }

    public function mentions()
    {
        include("templates/mentions-legales.php");
    }
    /**
     * Traitement du formaulaire de contact et envoie de mail
     */
    public function contact()
    {
        if(!empty($_POST))
        {
            $errors = $this->checkForm();

            if(empty($errors))
            {
                // Instantiation and passing `true` enables exceptions
                $mail = new PHPMailer(true);

                $messageState = false;
                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
                    $mail->isSMTP();                                            // Send using SMTP            
                    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                    $mail->Username   = 'portfolio.messages.julien.menard@gmail.com';                     // SMTP username
                    $mail->Password   = 'PortfolioJulienMenard.1234.';                               // SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` also accepted
                    $mail->Port       = 587;                                    // TCP port to connect to
                    
                    //à ne pas oublier pour éviter les problèmes d'accent ! 
                    $mail->CharSet = 'UTF-8';

                    //Recipients
                    $mail->setFrom($this->formInfos['email'], $this->formInfos['firstname'].' '.$this->formInfos['lastname']);
                    $mail->addAddress('julien.menard@students.campus.academy', 'Julien Menard');     // Add a recipient

                    // Content
                    $mail->isHTML(true);                                  // Set email format to HTML
                    $mail->Subject = 'Message Portfolio';
                    $mail->Body    = 'Message de '.$this->formInfos['firstname'].' '.$this->formInfos['lastname'].' de l\'entreprise '.$this->formInfos['entreprise'].' ('.$this->formInfos['location_entreprise'].') ['.$this->formInfos['email'].']<br><br><br>'.$this->formInfos['content'];

                    $mail->send();
                    //echo 'Message has been sent';
                    $messageState = true;
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $messageState = $mail->ErrorInfo;
                }
            }
        }

        include("templates/contact.php");
    }

    public function cv()
    {
        include("templates/cvpdf.php");
    }
    /**
     * Traite le formulaire et ajoute une recommandation dans la BDD
     */
    public function addRecommandations()
    {
        if(!empty($_POST))
        {
            $errors = $this->checkForm();

            if(empty($errors))
            {
                $manager = new Manager();
                $manager->saveNewRecommandation($this->formInfos);
                $recoSent = true;
            }
        }

        include("templates/add-reco-form.php");
    }

    public function allRecommandations()
    {
        $manager = new Manager();
        $allRecommandations = $manager->getAllRecommandations();

        include("templates/all-recommendations.php");
    }

    public function adminLogin()
    {
        //si le form est soumis... 
        if (!empty($_POST)) 
        {
            //par défaut je dis que c'est pas valide
            $formIsValid = false;

            //récupérer le username ou l'email 
            $email = $_POST['email'];
            //récupérer le mot de passe du form
            $password = $_POST['password'];

            //aller chercher dans la bdd la ligne correspondant à l'email
            $manager = new Manager();
            $foundUser = $manager->getAdminInfos($email);

            //si on a trouvé une ligne, un user avec cet email ou pseudo...
            if (!empty($foundUser)) 
            {
                //on compare son mdp
                $passwordIsValid = password_verify($password, $foundUser['password']);

                //si le mdp est bon...
                if ($passwordIsValid){
                    //connexion du user !!!!
                    $_SESSION['admin']['connected'] = true;
                    
                    header("Location: index.php");
                    die();
                }
                else
                {
                    //echo 'Mauvais mot de passe';
                }
            }
            else
            {
                //echo 'Mauvais identifiants';
            }
        }
        
        include("admin/templates/login.php");
    }

    public function adminPage()
    {
        if($_SESSION['admin']['connected'] === true)
        {
            $this->addWork();
        }
        else
        {
            include("templates/accueil.php");
        }
    }

    public function adminLogOff()
    {
        session_destroy();
        
        header("Location: index.php");
        die();
    }

    public function addWork()
    {
        if(!empty($_POST))
        {
            $errors = [];

            //seulement si on a un upload, on valide ! 
            if(!empty($_FILES['pic']))
            {
                //le fichier temporaire, uploadé sur le serveur
                $file = $_FILES['pic']['tmp_name'];

                //on s'assure que le type du fichier est safe
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $file);

                //les types mime que j'accepte
                $acceptedTypes = ["image/jpeg", "image/jpg", "image/png"];

                //je cherche le mime du fichier parmi ceux que j'accepte
                if (!in_array($mime, $acceptedTypes))
                {
                    $errors[] = "Type de fichier non accepté !";
                }

                // renseigner correctement les tailles dans le php.ini !!!
                // post_max_size 
                // upload_max_filesize 
                $size = $_FILES['pic']['size'];
                if ($size > 20000000)
                {
                    $errors[] = "Fichier trrop gros. 20 mb max svp.";
                }
                
                //on devine l'extension du fichier
                $extension = str_replace("image/", ".", $_FILES['pic']['type']);
                
                //génère une chaîne toujours unique
                $newFilename = uniqid() . $extension;
                
                //si l'upload est valide
                if (empty($errors))
                {
                    //déplace le fichier temporaire vers mon dossier à moi
                    move_uploaded_file(
                        $_FILES['pic']['tmp_name'], 
                        'assets/img/works/'.$newFilename
                    );

                    //on utilise SimpleImage pour redimensionner notre image
                    //https://github.com/claviska/SimpleImage 
                    $simpleImage = new \claviska\SimpleImage();

                    $simpleImage
                        ->fromFile("assets/img/works/$newFilename")
                        ->bestFit(500, 500)
                        //->sepia()
                        ->toFile("assets/img/works/$newFilename", null, 100);
                    }
            }

            $title = strip_tags($_POST['title']);
            $description = strip_tags($_POST['description']);
            $github = strip_tags($_POST['github']);
            $webLink = strip_tags($_POST['web-link']);
            $picture = $newFilename;

            if(empty($title))
            {
                $errors[] = "Votre article n'a pas de titre !";
            }
            elseif(strlen($title > 100))
            {
                $errors[] = "Titre trop long";
            }
            if(empty($description))
            {
                $errors[] = "Mettez une description SVP";
            }
            elseif(strlen($description > 500))
            {
                $errors[] = "Article trop long";
            }

            if(empty($github))
            {
                $github = null;
            }
            if(empty($webLink))
            {
                $webLink = null;
            }

            if(empty($errors))
            {
                $workInfos = [
                    "title" => $title,
                    "description" => $description,
                    "github" => $github,
                    "webLink" => $webLink,
                    "picture" => $picture,
                ];

                $manager = new Manager();
                $id = $manager->addWork($workInfos);

                header("Location: index.php?page=detail-projet&id=".$id);
            }
        }

        include("admin/templates/admin-page.php");
    }

    public function workDetails()
    {
        $manager = new Manager();
        $work = $manager->getWorkById($_GET['id']);
        if($work !== false)
        {
            include("templates/work-details.php");
        }
        else
        {
            $this->fourOfour();
        }
    }

    public function fourOfour()
    {
        include("templates/404.php");
    }
}

?>