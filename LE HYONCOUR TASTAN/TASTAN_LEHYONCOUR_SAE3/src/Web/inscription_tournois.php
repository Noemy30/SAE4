<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription à une Compétition</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <!-- Formulaire pour s'inscrire à une compétition -->
    <form action="ajouter_inscription.php" method="post">
        <label for="nom">Nom :</label>
        <input type="text" name="nom" required>
        <br>
        <label for="prenom">Prénom :</label>
        <input type="text" name="prenom" required>
        <br>
        <label for="niveau_pratique">Niveau de pratique :</label>
        <input type="text" name="niveau_pratique" required>
        <br>
        <label for="competition_id">ID de la Compétition :</label>
        <input type="number" name="competition_id" required>
        <br>
        <input type="submit" value="S'inscrire">
    </form>

    <!-- Liste des compétitions disponibles -->
    <h2>Compétitions Disponibles</h2>
    <?php include 'afficher_competitions_disponibles.php'; ?>
    <div class="footer">
        <a href="cgu.php">CGU</a>
    </div>
</body>
</html>
