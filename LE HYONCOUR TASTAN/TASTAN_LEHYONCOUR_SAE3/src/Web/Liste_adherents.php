<?php
require ('header1.php');
require ('connexion.php');

// Vérifier si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {


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


<head>
    <title>Liste des adhérents</title>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
    <link href="css/liste.css" rel="stylesheet" />
</head>

<body>

    <div class="adherents-container">
        <h2>Liste des adhérents</h2>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Niveau de pratique</th>
                <th>ID de la compétition</th>
                <th>Action Modifier</th>
                <th>Action Supprimer</th>
            </tr>
            <?php

            $sql = "SELECT ID,Nom, Prenom, Niveau FROM membre";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
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

    </div>
    <?php
    require('footer.php');
    ?>
</body>

</html>