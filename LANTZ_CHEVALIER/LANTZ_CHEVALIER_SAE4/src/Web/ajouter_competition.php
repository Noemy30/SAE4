<?php
require ('connexion.php');

$error_message = '';
$success_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $lieu = $_POST['lieu'];
    $horaire = $_POST['horaire'];
    $joueurs_necessaires = $_POST['joueurs_necessaires'];
    $places_disponibles = $_POST['places_disponibles'];

    $currentDate = date('Y-m-d\TH:i');
    if ($horaire < $currentDate) {
        $error_message = "La date et l'heure doivent être égales ou supérieures à la date actuelle.";
    } else {
        $sql = "INSERT INTO competitions (lieu, horaire, joueurs_necessaires, places_disponibles) 
                VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssii", $lieu, $horaire, $joueurs_necessaires, $places_disponibles);

        if ($stmt->execute()) {
            $success_message = "Compétition ajoutée avec succès.";
        } else {
            $error_message = "Erreur lors de l'ajout de la compétition : " . $conn->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<html>

<head>
    <title>Ajout d'une compétition</title>
    <link rel="stylesheet" href="css/competition1.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>
    <?php if (!empty($error_message)): ?>
        <div class="error-message"><?php echo $error_message; ?></div>
    <?php endif; ?>
    <?php if (!empty($success_message)): ?>
        <div class="success-message"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <div class="adherents-container">
        <h2>AJOUT D'UN TOURNOIS</h2>
        <a href="admin.php">Retour au menu administrateur</a>
    </div>
</body>

</html>