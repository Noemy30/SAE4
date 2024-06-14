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

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Télécharger un document</title>
    <link href="style.css" rel="stylesheet" />
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