<?php
// Connexion à la base de données (assurez-vous d'inclure le fichier de connexion)
include 'connexion.php';
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
<style>
     li{
        list-style-type: none; }
</style>