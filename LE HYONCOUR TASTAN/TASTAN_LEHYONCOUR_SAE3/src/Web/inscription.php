<?php
include 'connexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $niveau_pratique = $_POST['niveau_pratique'];
    $competition_id = $_POST['competition_id']; 

    $sql = "INSERT INTO inscriptionn (nom, prenom, niveau_pratique, competition_id) VALUES ('$nom', '$prenom', '$niveau_pratique', '$competition_id')";

    if ($conn->query($sql) === TRUE) {
        echo "Nouvel adhérent ajouté avec succès";
    } else {
        echo "Erreur : " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
