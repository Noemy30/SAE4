<?php
require('header1.php');
require('connexion.php');

// Vérifiez si l'utilisateur est connecté
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("Location: index.php");
    exit();
}

// Récupérez l'ID de l'utilisateur connecté
$login_id = $_SESSION['id'];

// Récupérez les informations de l'utilisateur
$membre = null;
$sql = "SELECT * FROM membre WHERE ID = ?";  // Assurez-vous que le champ ID correspond à celui que vous utilisez pour identifier les utilisateurs
if ($stmt = $conn->prepare($sql)) {
    $stmt->bind_param("s", $login_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $membre = $result->fetch_assoc();
    }
    $stmt->close();
}

$conn->close();

// Gérer le cas où les informations de l'utilisateur ne sont pas trouvées
if ($membre === null) {
    echo "Erreur : informations utilisateur introuvables.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <title>Profil de l'utilisateur</title>
    <link rel="stylesheet" href="css/membre.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>
    <div class="membre">
        <div class="title">
            <h2>Bienvenue dans l'espace membre, <?php echo htmlspecialchars($membre['Nom']); ?> <?php echo htmlspecialchars($membre['Prenom']); ?>!</h2>
        </div>
        <section class="container">
            <div class="col1">
                <!-- Ajoutez le contenu de l'espace membre ici -->
                <h2>Vos informations !</h2>
                <ul>
                    <li>Numéro de licence : <?php echo htmlspecialchars($membre['ID']); ?></li>
                    <li>Nom : <?php echo htmlspecialchars($membre['Nom']); ?></li>
                    <li>Prénom : <?php echo htmlspecialchars($membre['Prenom']); ?></li>
                    <li>Ville : <?php echo htmlspecialchars($membre['Ville']); ?></li>
                    <li>Age : <?php echo htmlspecialchars($membre['Age']); ?></li>
                    <li>Niveau : <?php echo htmlspecialchars($membre['Niveau']); ?></li>
                </ul>
            </div>
        </section>
    </div>
    <?php require('footer.php'); ?>
</body>
</html>
