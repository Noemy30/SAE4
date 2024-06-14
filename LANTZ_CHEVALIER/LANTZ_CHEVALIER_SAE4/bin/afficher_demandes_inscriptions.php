<?php
// Inclure le fichier de connexion à la base de données
include 'connexion.php';

// Récupérer les demandes d'inscription en attente
$sql = "SELECT * FROM demandes_inscription WHERE etat = 'en_attente'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // Afficher les demandes d'inscription dans un tableau
    echo "<table>";
    echo "<tr><th>Nom</th><th>Prénom</th><th>Niveau de pratique</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['nom'] . "</td>";
        echo "<td>" . $row['prenom'] . "</td>";
        echo "<td>" . $row['niveau_pratique'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "Aucune demande d'inscription en attente.";
}

// Fermer la connexion à la base de données
$conn->close();
?>
