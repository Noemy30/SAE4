<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include 'connexion.php'; // Assurez-vous d'inclure le fichier de connexion à la base de données

    $id = $_POST['id'];
    $password = $_POST['password'];

    // Vérifier les identifiants dans la base de données
    $sql = "SELECT * FROM membre WHERE ID = ? AND password = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $id, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        // Identifiants valides, enregistrer la session
        $_SESSION['loggedin'] = true;
        $_SESSION['id'] = $id;

        // Rediriger vers la page espace_membre.php
        header("Location: espace_membre.php");
        exit();
    } else {
        // Identifiants invalides
        $error_message = "Identifiants invalides. Veuillez réessayer.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link rel="stylesheet" href="style.css"> 

    <style>
        <style>
        body {
            background-image: url('background2.jpeg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
        }

        .login-container {
            text-align: center;
            max-width: 400px;
            margin: 0 auto;
            background-color: rgba(0, 0, 0, 0.7);
            border-radius: 10px;
            padding: 20px;
            margin-top: 100px;
        }

        .input-group {
            margin-bottom: 15px;
            text-align: left;
            margin-right: 17px;
        }

        .input-group label {
            display: block;
            font-size: 1.2em;
            margin-bottom: 5px;
            color: #E4FF00;
        }

        .input-group input {
            width: 100%;
            padding: 10px;
            border: none;
            background-color: #ffffff;
            border-radius: 5px;
        }

        .input-group button {
            background-color: #E4FF00;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            font-size: 1em;
            cursor: pointer;
            border-radius: 5px;
            width: 100%; 
        }

        .input-seconnecter {
            margin-right: -3px;
            margin-left: -1px;
        }

        .connexion {
            color: #E4FF00;
        }
        
    </style>
</head>
<body>
    <div class="navbar">
    <a href="index.php">Accueil</a>
        <a href="formulaire_inscription.php">S'inscrire</a>
        <a href="gestion_tournois.php">Tournois</a>
        <a href="galerie.php">Espace multimédia</a>
        <a href="document.php">Espace documentation</a>
        <a href="partenaire.php">Nos partenaires</a>
        <a href="espace_membre.php" ><img src="img/user.png" /></a>
        <a href="admin.php" ><img src="img/admin.png" /></a>
    </div>

    <section class="connexion-form">
        <div class="login-container">
            <h2 class="connexion">Connexion à votre espace membre</h2>
            <form action="login.php" method="post">
                <div class="input-group">
                    <label for="id">Numéro de licence :</label>
                    <input type="text" name="id" required>
                </div>
                <div class="input-group">
                    <label for="password">Mot de passe :</label>
                    <input type="password" name="password" required>
                </div>
                <div class="input-seconnecter">
                <button type="submit">Se connecter</button>
                </div>
            </form>
        <?php if(isset($error_message)) echo "<p class='error'>$error_message</p>"; ?>
        </div>
    </section>
    <div class="footer">
        <a href="cgu.php">CGU</a>
    </div>

</body>
</html>
