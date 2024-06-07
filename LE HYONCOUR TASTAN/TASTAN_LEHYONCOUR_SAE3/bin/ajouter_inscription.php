<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}
// Inclure le fichier de connexion
include 'connexion.php';

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
    $niveau_pratique = isset($_POST['niveau_pratique']) ? htmlspecialchars($_POST['niveau_pratique']) : '';
    $competition_id = isset($_POST['competition_id']) ? intval($_POST['competition_id']) : 0;

    // Vérifier si la compétition existe
    $check_competition = "SELECT places_disponibles FROM competitions WHERE id = $competition_id";
    $result_check = $conn->query($check_competition);

    if ($result_check && $result_check->num_rows > 0) {
        $row = $result_check->fetch_assoc();
        $places_disponibles = $row['places_disponibles'];

        // Vérifier s'il reste des places disponibles dans la compétition
        if ($places_disponibles > 0) {
            // Décrémenter le nombre de places disponibles
            $places_disponibles--;

            // Mettre à jour la table competitions
            $sql_update = "UPDATE competitions SET places_disponibles = $places_disponibles WHERE id = $competition_id";
            $result_update = $conn->query($sql_update);

            if ($result_update) {
                // Insérer l'inscription dans la table adherents
                $sql_insert = "INSERT INTO adherents (nom, prenom, niveau_pratique, competition_id) 
                               VALUES ('$nom', '$prenom', '$niveau_pratique', $competition_id)";
                $result_insert = $conn->query($sql_insert);

                if ($result_insert) {
                    echo "Inscription réussie.";
                } else {
                    echo "Erreur lors de l'inscription : " . $conn->error;
                }
            } else {
                echo "Erreur lors de la mise à jour des places disponibles : " . $conn->error;
            }
        } else {
            echo "Désolé, plus de places disponibles pour cette compétition.";
        }
    } else {
        echo "";
    }

    // Fermer la connexion à la base de données
    $conn->close();
} else {
    echo "Le formulaire n'a pas été soumis.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="style.css"> 
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
        <div class="navbar">
        <a href="index.php">Accueil</a>
        <a href="formulaire_inscription.php">S'inscrire</a>
        <a href="gestion_tournois.php">Tournois</a>
        <a href="galerie.php">Espace multimédia</a>
        <a href="document.php">Espace documentation</a>
        <a href="partenaire.php">Nos partenaires</a>
        <a href="espace_membre.php" ><img src="img/user.png" /></a>
        <a href="admin.php" ><img src="img/admin.png" /></a>
    </div>
    
    

    <div class="form-container">
    <h2>Inscription à une compétition</h2>
    <form action="ajouter_inscription.php" method="post">
        <label for="nom">Nom:</label>
        <input type="text" id="nom" name="nom" required><br>

        <label for="prenom">Prénom:</label>
        <input type="text" id="prenom" name="prenom" required><br>

        <label for="niveau_pratique">Niveau de pratique:</label>
        <input type="text" id="niveau_pratique" name="niveau_pratique" required><br>

        <label for="competition_id">ID de la compétition:</label>
        <input type="text" id="competition_id" name="competition_id" required><br>

        <input type="submit" value="Inscrire">
    </form>
    </div>
    <div class="footer">
        <a href="cgu.php">CGU</a>
    </div>
</body>
</html>
