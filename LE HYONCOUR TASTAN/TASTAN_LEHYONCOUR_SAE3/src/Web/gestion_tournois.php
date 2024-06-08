<?php 
require('header1.php'); 
require('connexion.php');
?>

<head>
    <title>Gestion des tournois</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link href="css/tournois.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>
    <div class="title">
        <h2>Tournois de Tennis</h2>
    </div>

    <div class="form-container">

        <h2>Liste des Compétitions 2024</h2>


        <table class="competition-table">
            <thead>
                <tr>
                    <th>Lieu</th>
                    <th>Horaire et Date</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer les données des compétitions depuis la base de données
                $sql = "SELECT lieu, horaire FROM competitions";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['lieu']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['horaire']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='2'>Aucune compétition trouvée</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="form-container">
        <h2>Compétitions avec places disponibles</h2>
        <table class="competition-table">
            <thead>
                <tr>
                    <th>Lieu</th>
                    <th>Horaire</th>
                    <th>Places disponibles</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Récupérer les compétitions avec places disponibles
                $sql = "SELECT lieu, horaire, places_disponibles FROM competitions WHERE places_disponibles > 0";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['lieu']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['horaire']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['places_disponibles']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>Aucune compétition avec places disponibles</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="form-container">
        <h2>Demandes d'inscription en attente</h2>
        <?php
        $sql = "SELECT * FROM demandes_inscription WHERE etat = 'en_attente'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Afficher les demandes d'inscription dans un tableau
            echo "<table>";
            echo "<tr><th>Nom</th><th>Prénom</th><th>Niveau de pratique</th></tr>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
                echo "<td>" . htmlspecialchars($row['niveau_pratique']) . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "Aucune demande d'inscription en attente.";
        }

        ?>
    </div>

    <div class="form-container">
        <h2>Inscription à une compétition</h2>
        <?php
       
        // Récupérer la liste des compétitions disponibles (places disponibles > 0)
        $sql = "SELECT * FROM competitions WHERE places_disponibles > 0";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // Afficher les compétitions dans un formulaire
            echo "<form action='ajouter_inscription.php' method='post'>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>";
                echo " ID de la compétition : " . $row['id'];
                echo "</li>";
                echo "<li>";
                echo $row['lieu'] . " - " . $row['horaire'] . " (Places disponibles : " . $row['places_disponibles'] . ")";
                echo "</li>";
            }
            echo "</ul>";
            echo "<input type='submit' value='Vous inscrire à une compétition ! '>";
            echo "</form>";
        } else {
            echo "Aucune compétition disponible pour le moment.";
        }
        // Fermer la connexion à la base de données
        $conn->close();
        ?>
    </div>

    <?php require('footer.php'); ?>
</body>

</html>
