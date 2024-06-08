<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        include 'connexion.php';

        // Récupérer les informations du fichier
        $img_nom = $_FILES["image"]["name"];
        $img_type = $_FILES["image"]["type"];
        $img_taille = $_FILES["image"]["size"];
        $img_blob = file_get_contents($_FILES["image"]["tmp_name"]);

        // Définir le chemin du dossier où les fichiers seront enregistrés
        $dossier = 'fichiers/';
        $chemin_fichier = $dossier . $img_nom;

        // Enregistrer le fichier dans le dossier
        move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_fichier);

        // Insérer le chemin du fichier dans la base de données
        $sql = "INSERT INTO document (img_nom, img_chemin) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $img_nom, $chemin_fichier);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Image téléchargée avec succès.";
        } else {
            echo "Erreur lors du téléchargement de l'image.";
        }

        // Fermer la connexion et la déclaration préparée
        $stmt->close();
        $conn->close();
    } else {
        echo "Aucun fichier sélectionné ou une erreur est survenue.";
    }
}
?>

<head>
    <title>Télécharger un document</title>
    <link href="css/document.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
        
</head>


<body>
    <div class="form-container">
        <h2>Choisir un document à envoyer</h2>
        <form action="document.php" method="post" enctype="multipart/form-data">
            <label for="image">Choisir une image :</label>
            <input type="file" name="image" accept="image/*" required>
            <br>
            <input type="submit" value="Télécharger">
        </form>
    </div>

    <div class="form-container">
    <h2>Télécharger nos documents administratifs</h2>
        <?php
        include 'connexion.php';

        // Récupérer les liens des fichiers depuis la base de données
        $sql = "SELECT id_fichier, nom_fich, chemin_fich FROM document_administratif";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<a href='" . $row["chemin_fich"] . "' download>Télécharger  " . $row["nom_fich"] . "</a><br>";
            }
        } else {
            echo "Aucun document trouvé.";
        }

        $conn->close();
        ?>
    </div>
    <div class="footer">
        <a href="cgu.php">CGU</a>
    </div>
</body>
</html>