<?php
require ('connexion.php');

?>

<html>

<head>
    <meta charset="UTF-8">
    <title>Ajout d'une compétition</title>
    <link rel="stylesheet" href="css/competition.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="adherents-container">
        <table>
            <h2>AJOUT D'UN TOURNOIS</h2>
            <?php
            $lieu = $_POST['lieu'];
            $horaire = $_POST['horaire'];
            $joueurs_necessaires = $_POST['joueurs_necessaires'];
            $places_disponibles = $_POST['places_disponibles'];

            $sql = "INSERT INTO competitions (lieu, horaire, joueurs_necessaires, places_disponibles) 
        VALUES ('$lieu', '$horaire', $joueurs_necessaires, $places_disponibles)";
            $result = $conn->query($sql);

            if ($result) {
                echo "Compétition ajoutée avec succès.";
            } else {
                echo "Erreur lors de l'ajout de la compétition : " . $conn->error;
            }

            $conn->close();
            ?>

    </div>
    </table>
    <a href="admin.php">Retour au menu administrateur</a>

    </div>
</body>

</html>