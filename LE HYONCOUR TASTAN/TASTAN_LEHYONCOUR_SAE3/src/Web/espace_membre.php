<?php
session_start();


if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
   
    header("Location: login.php");
    exit();
}

include 'connexion.php'; 
$id = $_SESSION['id'];
$sql = "SELECT * FROM membre WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $membre = $result->fetch_assoc();
} else {
    echo "Erreur: Membre non trouvé.";
    exit();
}

$stmt->close();
$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>

<body>
    <div class="navbar">
        <a href="index.php">Accueil</a>
        <a href="formulaire_inscription.php">S'inscrire</a>
        <a href="gestion_tournois.php">Tournois</a>
        <a href="galerie.php">Espace multimédia</a>
        <a href="document.php">Espace documentation</a>
        <a href="partenaire.php">Nos partenaires</a>
        <a href="espace_membre.php"><img src="img/user.png" /></a>
        <a href="admin.php"><img src="img/admin.png" /></a>
        <p id="deconnexion" class="button" style="cursor: pointer;">Déconnexion</p>
    </div>
    <h2>Bienvenue dans l'espace membre, <?php echo $membre['Nom']; ?> <?php echo $membre['Prenom']; ?>!</h2>
    <section class="container">
        <div class="col1">

            <!-- Ajoutez le contenu de l'espace membre ici -->
            <h2>Vos informations !</h2>
            <ul>
                <li>Numéro de licence : <?php echo $membre['ID']; ?></li>
                <li>Nom : <?php echo $membre['Nom']; ?></li>
                <li>Prénom : <?php echo $membre['Prenom']; ?></li>
                <li>Ville : <?php echo $membre['Ville']; ?></li>
                <li>Age : <?php echo $membre['Age']; ?></li>
                <li>Niveau : <?php echo $membre['Niveau']; ?></li>
            </ul>
        </div>

        <div class="col2">
            <!-- Contenu de la section du logo -->
            <img src="img/logo.png" alt="Logo">
        </div>
    </section>
    <script>// Script pour gérer la déconnexion lorsque le texte est cliqué
        document.getElementById("deconnexion").addEventListener("click", function () {
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "deconnexion.php", true);
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    window.location.href = "connexion_admin.php";
                }
            };
            xhr.send();
        });
    </script>
    <div class="footer">
        <a href="cgu.php">CGU</a>
    </div>
</body>

</html>