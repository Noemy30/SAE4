<?php
session_start();
require('connexion.php');

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['user_type'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];

        if ($user_type === 'member') {
            $sql = "SELECT * FROM membre WHERE Nom = ?";
        } elseif ($user_type === 'admin') {
            $sql = "SELECT * FROM admin WHERE Nom = ?";
        } else {
            $error_message = "Type d'utilisateur invalide.";
        }

        if (empty($error_message)) {
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("s", $login);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows === 1) {
                    $row = $result->fetch_assoc();
                    
                    // Récupérer le sel stocké
                    $stored_salt = $row['salt'];

                    // Combiner le sel stocké avec le mot de passe entré
                    $salted_password = $stored_salt . $password;

                    // Comparer les mots de passe hachés
                    if (($user_type === 'member' && password_verify($salted_password, $row['password'])) ||
                        ($user_type === 'admin' && password_verify($salted_password, $row['mdp']))) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['nom'] = $login;
                        $_SESSION['is_admin'] = $user_type === 'admin';

                        if ($user_type === 'member') {
                            header("Location: espace_membre.php");
                        } elseif ($user_type === 'admin') {
                            header("Location: admin.php");
                        }
                        exit();
                    } else {
                        $error_message = "Mot de passe incorrect.";
                    }
                } else {
                    $error_message = "Utilisateur non trouvé.";
                }

                $stmt->close();
            } else {
                $error_message = "Erreur lors de la préparation de la requête : " . $conn->error;
            }
        }
    } else {
        $error_message = "Veuillez remplir tous les champs.";
    }
}
$conn->close();
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Club de Tennis</title>
    <link rel="stylesheet" href="css/header1.css">
    <link rel="icon" href="img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Tenor+Sans&display=swap" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <div class="navbar">
            <div class="logo">
                <a href="index.php">
                    <img src="img/logo.png" alt="logo club">
                </a>
            </div>
            <nav>
                <a href="index.php">Accueil</a>
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    <a href="formulaire_inscription.php">S'inscrire</a>
                <?php endif; ?>
                <a href="gestion_tournois.php">Tournois</a>
                <a href="galerie.php">Multimédia</a>
                <a href="document.php">Documentation</a>
                <a href="partenaire.php">Partenaires</a>
                <?php if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true): ?>
                    <img src="img/utilisateur.png" alt="user icon" onclick="openLoginModal()">
                <?php endif; ?>
                <?php if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true): ?>
                    <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true): ?>
                        <a href="admin.php">Espace Admin</a>
                    <?php else: ?>
                        <a href="espace_membre.php">Mon compte</a>
                    <?php endif; ?>
                    <a href="logout.php">Déconnexion</a>
                <?php endif; ?>
            </nav>
        </div>
    </header>

    <div id="Connexion" class="modal">
        <form id="loginForm" class="modal-content animate" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="haut">
                <div class="logoModal">
                    <img src="img/logo.png" alt="logo club">
                </div>
                <span onclick="closeModal('Connexion')" class="close" title="Close Modal">&times;</span>
            </div>
            <div class="connectlog">
                <input type="text" placeholder="Nom d'utilisateur" name="login" id="login" required>
                <input type="password" placeholder="Mot de passe" name="password" id="password" required>
                <?php if (!empty($error_message)): ?>
                    <div class="error-message"><?php echo htmlspecialchars($error_message); ?></div>
                <?php endif; ?>
            </div>
            <div class="boutonlog">
                <button type="submit" class="okbtn">Valider</button>
                <button type="button" onclick="closeModal('Connexion')" class="cancelbtn">Annuler</button>
            </div>
            <div class="switch-user">
                <label>
                    <input type="radio" name="user_type" value="member" checked> Membre
                </label>
                <label>
                    <input type="radio" name="user_type" value="admin"> Administrateur
                </label>
            </div>
        </form>
    </div>

    <script src="script/modale.js"></script>
</body>
</html>
