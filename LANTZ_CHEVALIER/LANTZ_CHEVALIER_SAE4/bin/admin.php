<?php
session_start();

// Vérifier si l'administrateur est connecté
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Rediriger vers la page de connexion d'administrateur si non connecté
    header('Location: connexion_admin.php');
    exit();
}

if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header('Location: connexion_admin.php');
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Club de Tennis</title>
    <link href="style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">

</head>
<body>
<style>
    .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 700px;
        }
        .container{
        display:flex;
            }
        .col1{
        width:50%;
        /* background-color : grey; */
        justify-content: center;
        }
        .col2{
        width:50%;
        /* background-color : white; */
       text-align: center;
        }
        .button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #004080;
        color: #ffffff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }

    .button:hover {
        background-color: #0066cc;
    }

</style>
    <div class="navbar">
    <a href="formulaire_inscription.php">S'inscrire</a>
        <a href="gestion_tournois.php">Tournois</a>
        <a href="galerie.php">Espace multimédia</a>
        <a href="document.php">Espace documentation</a>
        <a href="partenaire.php">Nos partenaires</a>
        <a href="espace_membre.php" ><img src="img/user.png" /></a>
        <a href="admin.php" ><img src="img/admin.png" /></a>
        <p id="deconnexion" class="button" style="cursor: pointer;">Déconnexion</p>
    </div>

    <header style="text-align: center; padding: 50px;">
    <h1 style="font-size: 3em; color: #fff;">MENU ADMINISTRATEUR</h1>
    </header>

    <section class="container">
    <div class="col1">

    <!-- Formulaire pour saisir une compétition -->
    <div class="form-container">
    <h2>Ajouter une compétition</h2>
    <form action="ajouter_competition.php" method="post">
        <label for="lieu">Lieu :</label>
        <input type="text" name="lieu" required>
        <br>
        <label for="horaire">Horaire :</label>
        <input type="datetime-local" name="horaire" required>
        <br>
        <label for="joueurs_necessaires">Nombre de joueurs nécessaires :</label>
        <input type="number" name="joueurs_necessaires" required>
        <br>
        <label for="places_disponibles">Places disponibles :</label>
        <input type="number" name="places_disponibles" required>
        <br>
        <input type="submit" value="Ajouter Compétition">
    </form>
    </div>

    <!-- Liste des compétitions existantes -->
    <div class="form-container">
        <h2>Liste des Compétitions</h2>
        <?php include 'afficher_competitions.php'; ?>
    </div>
    <div class="form-container">
        <!-- Liste des demandes d'inscription -->
        <h2>Fichier disponible au téléchargement</h2>
        <?php
        include 'connexion.php';

        // Récupérer les liens des fichiers depuis la base de données
        $sql = "SELECT id_img, img_nom, img_chemin FROM document";
        $result = $conn->query($sql);

        if ($result && $result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<a href='telecharger_document.php?id=" . $row["id_img"] . "'>Télécharger Document " . $row["img_nom"] . "</a><br>";
            }
        } else {
            echo "Aucun document trouvé.";
        }

        $conn->close();
        ?>
    </div>
    </div>
    <div class="col2">
    <div class="form-container">
        <h2>Ajouter un document administratif</h2>
        <form action="admin.php" method="post" enctype="multipart/form-data">
            <label for="image">Choisir un fichier :</label>
            <input type="file" name="image" accept="image/*" required>
            <br>
            <input type="submit" value="Télécharger">
        </form>
    </div>

<?php    
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
        $dossier = 'documentAdmin/';
        $chemin_fichier = $dossier . $img_nom;

        // Enregistrer le fichier dans le dossier
        move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_fichier);

        // Insérer le chemin du fichier dans la base de données
        $sql = "INSERT INTO document_administratif (nom_fich, chemin_fich) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $img_nom, $chemin_fichier);

        // Exécuter la requête
        if ($stmt->execute()) {
            echo "Document téléchargée avec succès.";
        } else {
            echo "Erreur lors du téléchargement du document.";
        }

        // Fermer la connexion et la déclaration préparée
        $stmt->close();
        $conn->close();
    } else {
        echo "Aucun fichier sélectionné ou une erreur est survenue.";
    }
}
?>

<div class="form-container">
        <h2>Ajouter une image à la galerie</h2>
        <form action="uploadgalerie.php" method="post" enctype="multipart/form-data">
            <label for="image">Choisir une image :</label>
            <input type="file" name="image" accept="image/*" required>
            <br>
            <input type="submit" value="Télécharger">
        </form>
    </div>


    <div class="form-container">
    <a href="liste_adherents.php" class="button">Liste des adhérents</a>

    </div>
    </div>   
   <script>// Script pour gérer la déconnexion lorsque le texte est cliqué
        document.getElementById("deconnexion").addEventListener("click", function() {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deconnexion.php", true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.href = "connexion_admin.php";
                }
            };
            xhr.send();
        });
    </script>

</body>
</html>
