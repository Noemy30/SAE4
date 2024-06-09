<?php
require ('connexion.php');

$error_messages = []; // Initialiser un tableau pour les messages d'erreur

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
    $niveau_pratique = isset($_POST['niveau_pratique']) ? htmlspecialchars($_POST['niveau_pratique']) : '';
    $competition_id = isset($_POST['competition_id']) ? intval($_POST['competition_id']) : 0;

    // Vérifier si la personne est déjà inscrite
    $check_duplicate = "SELECT * FROM adherents WHERE nom = '$nom' AND prenom = '$prenom' AND competition_id = $competition_id";
    $result_duplicate = $conn->query($check_duplicate);

    if ($result_duplicate && $result_duplicate->num_rows > 0) {
        $error_messages[] = "La personne $nom $prenom est déjà inscrite pour cette compétition.";
    } else {
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
                        $success_message = "Inscription réussie.";
                    } else {
                        $error_messages[] = "Erreur lors de l'inscription : " . $conn->error;
                    }
                } else {
                    $error_messages[] = "Erreur lors de la mise à jour des places disponibles : " . $conn->error;
                }
            } else {
                $error_messages[] = "Désolé, plus de places disponibles pour cette compétition.";
            }
        } else {
            $error_messages[] = "La compétition spécifiée n'existe pas.";
        }
    }

    // Fermer la connexion à la base de données
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="css/inscriptionT.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap" rel="stylesheet">
</head>
<body>

    <div id="messages">
        <?php if (!empty($error_messages)): ?>
            <?php foreach ($error_messages as $message): ?>
                <div class="error-message"><?php echo $message; ?></div>
            <?php endforeach; ?>
        <?php elseif (!empty($success_message)): ?>
            <div class="success-message"><?php echo $success_message; ?></div>
        <?php endif; ?>
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
        <div class="retourAccueil">
            <a href="index.php">Retournez à l'Accueil</a>
        </div>
    </div>

</body>
</html>
