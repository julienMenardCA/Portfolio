<?php 
spl_autoload_register();
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader
require 'vendor/autoload.php';

Class Controller
{
    private $formInfos = [];

    public function home()
    {
        $manager = new Manager();
        $recommandations = $manager->getSomeRecommandations();

        include("templates/accueil.php");
    }

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

    public function fourOfour()
    {
        include("templates/404.php");
    }
}

?>