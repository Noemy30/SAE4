<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des adhérents</title>
    <link rel="stylesheet" href="css/traitement_modifier.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>

    <div class="adherents-container">
        <table>
            <h2>MODIFICATION D'UN MEMBRE</h2>
            <?php
            require ('connexion.php');

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $membre_id = intval($_POST['id']);
                $nouveau_nom = $_POST['nom'];
                $nouveau_prenom = $_POST['prenom'];
                $nouveau_niveau = $_POST['niveau'];

                $sql_update = "UPDATE membre SET Nom='$nouveau_nom', Prenom='$nouveau_prenom', Niveau='$nouveau_niveau' WHERE ID=$membre_id";
                $result_update = $conn->query($sql_update);

                if ($result_update) {
                    echo "Membre mis à jour avec succès.";
                } else {
                    echo "Erreur lors de la mise à jour du membre : " . $conn->error;
                }
            }
            ?>
    </div>
    </table>
    <form action="admin.php" method="post">
        <input type="submit" value="Retour au menu administrateur">
    </form>

    </div>
</body>

</html>