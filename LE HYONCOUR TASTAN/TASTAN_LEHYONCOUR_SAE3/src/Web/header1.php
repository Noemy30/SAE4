<!DOCTYPE html>
<html lang="en">

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
                <a href="formulaire_inscription.php">S'inscrire</a>
                <a href="gestion_tournois.php">Tournois</a>
                <a href="galerie.php">Multimédia</a>
                <a href="document.php">Documentation</a>
                <a href="partenaire.php">Partenaires</a>
                <img src="img/utilisateur.png" alt="user icon" onclick="openLoginModal()">
            </nav>
        </div>
    </header>


    <div id="imageModal" class="modal">
        <span class="close" onclick="closeModal('imageModal')">&times;</span>
        <img class="modal-content" id="modalImage">
        <div id="caption"></div>
    </div>

    <div id="Connexion" class="modal">
        <form id="loginForm" class="modal-content animate"
            action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="haut">
                <div class="logoModal">
                    <img src="img/logo.png" alt="logo club">
                </div>
                <span onclick="closeModal('Connexion')" class="close" title="Close Modal">&times;</span>
            </div>
            <input type="hidden" name="action" value="login">
            <div class="connectlog">
                <input type="text" placeholder="Nom d'utilisateur" name="login" id="login" required>
                <input type="password" placeholder="Mot de passe" name="password" id="password" required>
            </div>
            <div class="boutonlog">
                <button type="submit" class="okbtn">Valider</button>
                <button type="button" onclick="closeModal('Connexion')" class="cancelbtn">Annuler</button>
            </div>
        </form>
    </div>

    <script src="script/modale.js"></script>
</body>

</html>