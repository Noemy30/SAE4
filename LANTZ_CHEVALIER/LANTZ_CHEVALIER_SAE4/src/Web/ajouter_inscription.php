<?php
require ('connexion.php');

$error_messages = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = isset($_POST['nom']) ? htmlspecialchars($_POST['nom']) : '';
    $prenom = isset($_POST['prenom']) ? htmlspecialchars($_POST['prenom']) : '';
    $niveau_pratique = isset($_POST['niveau_pratique']) ? htmlspecialchars($_POST['niveau_pratique']) : '';
    $competition_id = isset($_POST['competition_id']) ? intval($_POST['competition_id']) : 0;

    if ($competition_id > 0) {
        $check_existing = "SELECT * FROM adherents WHERE nom = '$nom' AND prenom = '$prenom' AND competition_id = $competition_id";
        $result_existing = $conn->query($check_existing);

        if ($result_existing && $result_existing->num_rows > 0) {
            $error_messages = "Vous êtes déjà inscrit à cette compétition.";
        } else {
            $check_competition = "SELECT places_disponibles FROM competitions WHERE id = $competition_id";
            $result_check = $conn->query($check_competition);

            if ($result_check) {
                if ($result_check->num_rows > 0) {
                    $row = $result_check->fetch_assoc();
                    $places_disponibles = $row['places_disponibles'];

                    if ($places_disponibles > 0) {
                        $places_disponibles--;

                        $sql_update = "UPDATE competitions SET places_disponibles = $places_disponibles WHERE id = $competition_id";
                        $result_update = $conn->query($sql_update);

                        if ($result_update) {
                            $sql_insert = "INSERT INTO adherents (nom, prenom, niveau_pratique, competition_id) 
                                           VALUES ('$nom', '$prenom', '$niveau_pratique', $competition_id)";
                            $result_insert = $conn->query($sql_insert);
                            if ($result_insert) {
                                $success_message = "Inscription réussie.";
                            } else {
                                $error_messages = "Erreur lors de l'inscription. Veuillez vérifier les informations.";
                            }
                        } else {
                            $error_messages = "Erreur lors de la mise à jour des places disponibles.";
                        }
                    } else {
                        $error_messages = "Il n'y a plus de places disponibles pour cette compétition.";
                    }
                } else {
                    $error_messages = "Compétition introuvable.";
                }
            } else {
                $error_messages = "Erreur lors de la vérification de la compétition.";
            }
        }
    }
}

$conn->close();
?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Formulaire d'Inscription</title>
    <link rel="stylesheet" href="css/inscriptionT.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet">
</head>

<body>

    <div id="messages">
        <?php
        if (!empty($error_messages)) {
            echo "<div class='error-message'>$error_messages</div>";
        }
        if (!empty($success_message)) {
            echo "<div class='success-message'>$success_message</div>";
        }
        ?>
    </div>

    <div class="form-container">
        <h2>Inscription à une compétition</h2>
        <form action="" method="post">
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required><br>

            <label for="prenom">Prénom:</label>
            <input type="text" id="prenom" name="prenom" required><br>

            <label for="niveau_pratique">Niveau de pratique:</label>
            <input type="text" id="niveau_pratique" name="niveau_pratique" required><br>

            <label for="competition_id">ID de la compétition:</label>
            <input type="text" id="competition_id" name="competition_id" pattern="\d+" title="Seuls les chiffres sont autorisés" required><br>

            <input type="submit" value="Inscrire">
        </form>
        <div class="retourAccueil">
            <a href="index.php">Retourner à l'Accueil</a>
        </div>
    </div>

</body>

</html>
