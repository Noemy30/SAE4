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

        td a {
            background-color: #008CBA;;
            color: #ffffff;
            border: none;
            padding: 5px 5px;
            border-radius : 5%;
            font-size: 1em;
            cursor: pointer;
        }
        td a:hover {
            background-color: #FFCCCB;
            color: black;
            border: none;
            padding: 5px 5px;
            border-radius : 5%;
            font-size: 1em;
            cursor: pointer;
        }
    </style>
</head>
<body>
    
<?php
session_start();

// Vérifier si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connexion.php';

    // Récupérer les données du formulaire
    $nom_utilisateur = htmlspecialchars($_POST["nom_utilisateur"]);
    $mot_de_passe = htmlspecialchars($_POST["mot_de_passe"]);

    // Requête SQL pour vérifier les informations d'identification
    $sql = "SELECT * FROM admin WHERE nom_utilisateur = '$nom_utilisateur' AND mdp = '$mot_de_passe'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Informations d'identification valides
        $_SESSION['is_admin'] = true;
        $_SESSION['last_activity'] = time();
    } else {
        // Informations d'identification invalides
        echo "<p style='color: red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
    }

    $conn->close();
}

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    // Rediriger vers la page de connexion
    header('Location: login.php');
    exit();
}

// Vérifier si la session est expirée (30 minutes d'inactivité)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}

// Mettre à jour le dernier horodatage d'activité
$_SESSION['last_activity'] = time();
?>
    

    <div class="adherents-container">
        <h2>Liste des adhérents</h2>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Niveau de pratique</th>
                <th>ID de la compétition</th>
            </tr>
            <?php
            include 'connexion.php';

            $sql = "SELECT ID,Nom, Prenom, Niveau FROM membre"; 
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row["Nom"] . "</td>";
                    echo "<td>" . $row["Prenom"] . "</td>";
                    echo "<td>" . $row["Niveau"] . "</td>";
                    echo "<td>" . $row["ID"] . "</td>";
                    echo "<td><a href='modifier_membre.php?id=" . $row["ID"] . "'>Modifier</a></td>";
                    echo "<td><a href='supprimer_membre.php?id=" . $row["ID"] . "'>Supprimer</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='3'>Aucun adhérent trouvé</td></tr>";
            }

            $conn->close();
            ?>
        </table>
        <p class="logout-button">
        <form action="deconnexion.php" method="post">
            <input type="submit" value="Déconnexion">
        </form>
        </p>
        

        <form action="index.php" method="post">
        <input type="submit" value="Retour à l'accueil">
        </form>

    </div>
</body>
</html>