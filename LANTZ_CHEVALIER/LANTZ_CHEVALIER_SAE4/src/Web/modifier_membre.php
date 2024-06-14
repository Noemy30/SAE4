<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des adhérents</title>
    <link rel="stylesheet" href="css/modifier.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>

    <div class="adherents-container">
        <table>
            <h2>MODIFICATION D'UN MEMBRE</h2>
            <?php
            require ('connexion.php');

            if (isset($_GET['id'])) {
                $membre_id = intval($_GET['id']);

                $sql = "SELECT * FROM membre WHERE ID = $membre_id";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    $membre = $result->fetch_assoc();
                    echo "<form action='traitement_modifier_membre.php' method='post'>";
                    echo "<input type='hidden' name='id' value='" . $membre["ID"] . "'>";
                    echo "Nom: <input type='text' name='nom' value='" . $membre["Nom"] . "'><br>";
                    echo "Prénom: <input type='text' name='prenom' value='" . $membre["Prenom"] . "'><br>";
                    echo "Niveau de pratique: <input type='text' name='niveau' value='" . $membre["Niveau"] . "'><br>";
                    echo "<input type='submit' value='Modifier'>";
                    echo "</form>";
                } else {
                    echo "Membre non trouvé.";
                }

                $conn->close();
            } else {
                echo "ID de membre non fourni.";
            }
            ?>

    </div>
    </table>
</body>

</html>