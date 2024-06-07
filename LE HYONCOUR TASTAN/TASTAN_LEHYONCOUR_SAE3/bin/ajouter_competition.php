<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajout d'une compétition</title>
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
    <h2>AJOUT D'UN TOURNOIS</h2>
<?php
// Connexion à la base de données (assurez-vous d'inclure le fichier de connexion)
include 'connexion.php';
// Récupération des données du formulaire
$lieu = $_POST['lieu'];
$horaire = $_POST['horaire'];
$joueurs_necessaires = $_POST['joueurs_necessaires'];
$places_disponibles = $_POST['places_disponibles'];

// Insertion dans la table competitions
$sql = "INSERT INTO competitions (lieu, horaire, joueurs_necessaires, places_disponibles) 
        VALUES ('$lieu', '$horaire', $joueurs_necessaires, $places_disponibles)";
$result = $conn->query($sql);

if ($result) {
    echo "Compétition ajoutée avec succès.";
} else {
    echo "Erreur lors de l'ajout de la compétition : " . $conn->error;
}

// Fermer la connexion à la base de données
$conn->close();
?>

</div>
        </table>
        <form action="admin.php" method="post">
        <input type="submit" value="Retour au menu administrateur">
        </form>

    </div>
</body>
</html>