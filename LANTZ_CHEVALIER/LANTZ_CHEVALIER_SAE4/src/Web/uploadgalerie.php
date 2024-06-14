<?php
require ('connexion.php')
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des adhérents</title>
    <link rel="stylesheet" href="css/uploadGalerie.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>

    <div class="adherents-container">
        <table>
            <h2>AJOUT A LA GALERIE</h2>
            <?php

            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

                    $img_nom = $_FILES["image"]["name"];
                    $img_type = $_FILES["image"]["type"];
                    $img_taille = $_FILES["image"]["size"];
                    $img_blob = file_get_contents($_FILES["image"]["tmp_name"]);

                    $dossier = 'img/';
                    $chemin_fichier = $dossier . $img_nom;

                    move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_fichier);

                    $sql = "INSERT INTO galerie (nom_img, chemin_img) VALUES (?, ?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ss", $img_nom, $chemin_fichier);

                    if ($stmt->execute()) {
                        echo "Document téléchargée avec succès.";
                    } else {
                        echo "Erreur lors du téléchargement du document.";
                    }

                    $stmt->close();
                    $conn->close();
                } else {
                    echo "Aucun fichier sélectionné ou une erreur est survenue.";
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