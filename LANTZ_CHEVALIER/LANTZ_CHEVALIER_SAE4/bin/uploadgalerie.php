<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des adhérents</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <style>
        body {
            background-image: url('background2.jpeg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            color: #ffffff; 
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .adherents-container {
            max-width: 800px;
            padding: 40px;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            text-align: center;
        }

        h2 {
            font-size: 2em;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        table, th, td {
            border: 1px solid #ffffff;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #333333;
        }

        tr:nth-child(even) {
            background-color: #666666;
        }

        tr:nth-child(odd) {
            background-color: #555555;
        }

        .button-container {
            text-align: center;
            margin-top: 20px;
        }

        .logout-button[type="submit"] {
            margin-bottom: 10px;
        }

        input[type="submit"] {
            background-color: #008CBA;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }

        input[type="submit"]:hover {
            background-color: #005f6b;
        }
    </style>
</head>
<body>
    
<div class="adherents-container">
<table>
    <h2>AJOUT A LA GALERIE</h2>
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
        $dossier = 'image/';
        $chemin_fichier = $dossier . $img_nom;

        // Enregistrer le fichier dans le dossier
        move_uploaded_file($_FILES["image"]["tmp_name"], $chemin_fichier);

        // Insérer le chemin du fichier dans la base de données
        $sql = "INSERT INTO galerie (nom_img, chemin_img) VALUES (?, ?)";
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
</div>
        </table>
        <form action="admin.php" method="post">
        <input type="submit" value="Retour au menu administrateur">
        </form>

    </div>
</body>
</html>