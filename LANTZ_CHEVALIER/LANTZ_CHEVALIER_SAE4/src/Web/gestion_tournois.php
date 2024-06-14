<?php
require ('header1.php');
require ('connexion.php');

$isUserLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
?>

<html>

<head>
    <title>Gestion des tournois</title>
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
        <table class="competition-table">
            <h2>Demandes d'inscription en attente</h2>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Niveau de pratique</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM demandes_inscription WHERE etat = 'en_attente'";
                $result = $conn->query($sql);
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['nom']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['prenom']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['niveau_pratique']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "Aucune demande d'inscription en attente.";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="form-container">
        <h2>Inscription à une compétition</h2>
        <?php
        $sql = "SELECT * FROM competitions WHERE places_disponibles > 0";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            echo "<form action='ajouter_inscription.php' method='post'>";
            echo "<ul>";
            while ($row = $result->fetch_assoc()) {
                echo "<li>ID de la compétition : " . htmlspecialchars($row['id']) . "</li>";
                echo "<li>" . htmlspecialchars($row['lieu']) . " - " . htmlspecialchars($row['horaire']) . " (Places disponibles : " . htmlspecialchars($row['places_disponibles']) . ")</li>";
            }
            echo "</ul>";
            if ($isUserLoggedIn) {
                echo "<input type='submit' value='Vous inscrire à une compétition !'>";
            } else {
                echo "<p>Vous devez être connecté pour vous inscrire à une compétition.</p>";
            }
            echo "</form>";
        } else {
            echo "Aucune compétition disponible pour le moment.";
        }
        $conn->close();
        ?>
    </div>


    <?php require ('footer.php'); ?>
</body>

</html>