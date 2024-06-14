<?php
require ('header1.php');
require ('connexion.php');

$conn->set_charset('utf8mb4');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {

        $img_nom = $_FILES["image"]["name"];
        $img_type = $_FILES["image"]["type"];
        $img_taille = $_FILES["image"]["size"];
        $img_blob = file_get_contents($_FILES["image"]["tmp_name"]);

        $dossier = 'fichiers/';
        $chemin_fichier = $dossier . $img_nom;

        move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_fichier);

        $sql = "INSERT INTO document (img_nom, img_chemin) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $img_nom, $chemin_fichier);

        if ($stmt->execute()) {
            echo "Image téléchargée avec succès.";
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }

        $stmt->close();
    } else {
        echo "Aucun fichier sélectionné ou une erreur est survenue.";
    }
}

?>

<html>

<head>
    <title>Télécharger un document</title>
    <link href="css/documentation.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>
    <div class="container-docEnvoyer">
        <div class="form-container">
            <div class="docAEnvoyer">
                <h2>Choisir un document à envoyer</h2>
            </div>

            <form action="document.php" method="post" enctype="multipart/form-data">
                <label for="image">Choisir une image :</label>
                <input type="file" name="image" accept="image/*" required>
                <br>
                <input type="submit" value="Télécharger">
            </form>
        </div>
    </div>

    <div class="telecharger">
        <div class="form-container">
            <h2>Télécharger nos documents administratifs</h2>
            <?php
            require ('connexion.php');
            $conn->set_charset('utf8mb4');

            $sql = "SELECT id_fichier, nom_fich, chemin_fich FROM document_administratif";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<a href='" . htmlspecialchars($row["chemin_fich"], ENT_QUOTES, 'UTF-8') . "' download>Télécharger " . htmlspecialchars($row["nom_fich"], ENT_QUOTES, 'UTF-8') . "</a><br>";
                }
            } else {
                echo "<div class='no-documents'>Aucun document trouvé.</div>";
            }

            $conn->close();
            ?>
        </div>
    </div>

    <?php
    require ('footer.php');
    ?>
</body>

</html>