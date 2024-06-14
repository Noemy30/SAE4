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
    <h2>SUPPRESSION D'UN MEMBRE</h2>
<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $membre_id = intval($_GET['id']);

    // Effectuez une requête pour supprimer le membre
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