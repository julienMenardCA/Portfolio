<?php 

/**
 * Cette classe contient toutes les requêtes SQL !
 * Une requête par méthode ! 
 * SRP : single responsability principle
 */
class Manager
{
    public function getRecommandations()
    {
        $sql = "SELECT *
                FROM recommandations
                ORDER BY date_created DESC
                LIMIT 5";

        $pdo = DbConnection::getPdo();

        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        $postsHome = $stmt->fetchAll();
        return $postsHome;
    }

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

}