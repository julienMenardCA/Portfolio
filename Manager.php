<?php 
/**
 * Cette classe contient toutes les requêtes SQL !
 * Une requête par méthode ! 
 * SRP : single responsability principle
 */
class Manager
{
    /**
     * Récupère les 5 dernières recommandations dans la BDD pour les afficher dans le carousel
     */
    public function getSomeRecommandations()
    {
        $sql = "SELECT *
                FROM recommandations
                ORDER BY date_created DESC
                LIMIT 5";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $recosHome = $stmt->fetchAll();
        return $recosHome;
    }

    /**
     * Récupère toutes les recommandations dans la BDD
     */
    public function getAllRecommandations()
    {
        $sql = "SELECT *
                FROM recommandations
                ORDER BY date_created DESC";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $postsHome = $stmt->fetchAll();
        return $postsHome;
    }

    /**
     * Sauvegarde une nouvelle recommandation
     * $formInfos : les informations du formulaire d'ajout de recommandation
     */
    public function saveNewRecommandation($formInfos)
    {
        $datetime = new DateTime();
        $datetime = $datetime->format("d/m/y à H:i:s");

        $sql = "INSERT INTO 
                recommandations (nom, prenom, mail, entreprise, location_entreprise, commentaire, date_created)
                VALUES
                (:lastname, :firstname , :email, :entreprise, :location_entreprise, :content, :date_created)";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":lastname" => $formInfos['lastname'],
            ":firstname" => $formInfos['firstname'],
            ":email" => $formInfos['email'],
            ":entreprise" => $formInfos['entreprise'],
            ":location_entreprise" => $formInfos['location_entreprise'],
            ":content" => $formInfos['content'],
            ":date_created" => $datetime,
        ]);
    }

    /**
     * Récupère les infos d'admin dans la BDD pour se connecter et accéder aux fonctions d'admin
     */
    public function getAdminInfos($email)
    {
        $sql = "SELECT * FROM admin 
                WHERE  login_email = :email";

        //récupère notre connexion à la bdd
        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":email" => $email,
        ]);

        $adminInfos = $stmt->fetch();
        return $adminInfos;
    }

    /**
     * Ajoute un nouveau projet dans la BDD
     * $workInfos : les informations du formulaire d'ajout de projet
     */
    public function addWork($workInfos)
    {
        $sql = "INSERT INTO 
                travaux (titre, description, image, lien_github, lien_web)
                VALUES
                (:titre, :description, :image, :lien_github, :lien_web)";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);

        $stmt->execute([
            ":titre" => $workInfos['title'],
            ":description" => $workInfos['description'],
            ":image" => $workInfos['picture'],
            ":lien_github" => $workInfos['github'],
            ":lien_web" => $workInfos['webLink'],
        ]);

        return $pdo->lastInsertId();
    }

    /**
     * Récupère un projet par son $id pour ensuite en afficher les détails dans une page prévu à cet effet
     */
    public function getWorkById($id)
    {
        $sql = "SELECT *
                FROM travaux
                WHERE id = :id";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ":id" => $id,
        ]);

        $postById = $stmt->fetch();
        return $postById;
    }

    /**
     * Récupère les 5 derniers projets dans la BDD pour les afficher dans le carousel
     */
    public function getSomeWorks()
    {
        $sql = "SELECT *
                FROM travaux
                ORDER BY date_created DESC
                LIMIT 5";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $worksHome = $stmt->fetchAll();
        return $worksHome;
    }

}