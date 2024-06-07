<!-- Connexion à la base de données -->
<?php include 'connexion.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Afficher les Compétitions</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <!-- Ajoutez vos styles CSS ici -->
</head>
<body>
    <!-- Reste du code -->
    
    <?php
    // Récupérer la liste des compétitions
    $sql = "SELECT * FROM competitions";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Afficher les compétitions dans un tableau
        echo "<table>";
        echo "<tr><th>Lieu</th><th>Horaire</th><th>Joueurs Nécessaires</th><th>Places Disponibles</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['lieu'] . "</td>";
            echo "<td>" . $row['horaire'] . "</td>";
            echo "<td>" . $row['joueurs_necessaires'] . "</td>";
            echo "<td>" . $row['places_disponibles'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Aucune compétition pour le moment.";
    }

    // Fermer la connexion à la base de données
    $conn->close();
    ?>

    <!-- Reste du code -->
</body>
</html>
