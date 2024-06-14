<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des adhérents</title>
    <link rel="stylesheet" href="css/supprimer.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>

    <div class="adherents-container">
        <table>
            <h2>SUPPRESSION D'UN MEMBRE</h2>
            <?php
            require ('connexion.php');

            if (isset($_GET['id'])) {
                $membre_id = intval($_GET['id']);
                $sql_delete = "DELETE FROM membre WHERE ID = $membre_id";
                $result_delete = $conn->query($sql_delete);

                if ($result_delete) {
                    echo "Membre supprimé avec succès.";
                } else {
                    echo "Erreur lors de la suppression du membre : " . $conn->error;
                }

                $conn->close();
            } else {
                echo "ID de membre non fourni.";
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