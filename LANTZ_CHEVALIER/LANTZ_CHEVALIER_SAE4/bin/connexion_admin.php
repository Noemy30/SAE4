<?php
session_start();

// Vérifier si l'administrateur est déjà connecté, rediriger vers admin.php si c'est le cas
if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
    header('Location: admin.php');
    exit();
}


// Vérifier si le formulaire de connexion est soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connexion.php'; // Assurez-vous d'inclure le fichier de connexion à la base de données

    $id = $_POST['username'];
    $password = $_POST['password'];

    // Vérifier les identifiants dans la base de données
    $sql = "SELECT * FROM admin WHERE ID = ? AND mdp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Vérifier les informations d'identification de l'administrateur
    if ($result->num_rows === 1) {
        // Informations d'identification valides, définir la session d'administrateur
        $_SESSION['is_admin'] = true;
        header('Location: admin.php');
        exit();
    } else {
        $erreur = "Nom d'utilisateur ou mot de passe incorrect.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion Administrateur</title>
    <link href="style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">
</head>
<body>

    <div class="navbar">
        <a href="index.php">Retour à l'accueil</a>
    </div>

    <section class="connexion-form">
        <div class="login-container">
            <h2 class="connexion">Connexion Administrateur</h2>
            <form action="connexion_admin.php" method="post">
                <div class="input-group">
                    <label for="username">Nom d'utilisateur:</label>
                    <input type="text" id="username" name="username" required><br>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" required><br>
                </div>
                <div class="input-seconnecter">
                <button type="submit">Se connecter</button>
                </div>
            </form>
            <?php if(isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
            
        </div>
    </section>

</body>

</html>

