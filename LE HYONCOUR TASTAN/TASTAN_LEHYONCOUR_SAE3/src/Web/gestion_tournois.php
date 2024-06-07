<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des tournois</title>
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link href="style.css" rel="stylesheet" />
    <style>
        body {
            background-image: url('background2.jpeg');
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            text-align: center;
            color: Black;
        }

        .navbar {
            overflow: hidden;
            display: flex;
            justify-content: center;
            background-color: #E4FF00;
        }

        .navbar a {
            color: #000000;
            text-align: center;
            padding: 14px 20px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .navbar a:hover {
            background-color: #FFFFFF;
            color: #E4FF00;
        }

        @media screen and (max-width: 600px) {
            .navbar {
                flex-direction: column;
            }
        }

        .form-container {
            background-color: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 700px;
        }

        .form-container input {
            width: calc(100% - 20px);
            padding: 10px;
            margin: 5px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .form-container input[type="submit"] {
            background-color: #E4FF00;
            color: #000;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
        }

        .form-container input[type="submit"]:hover {
            background-color: #FFFFFF;
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


    <h2>Tournois de Tennis</h2>
        <div class="form-container">
            <ul>
                    <!-- Liste des compétitions existantes -->
                <h2>Liste des Compétitions 2024</h2>
                <?php include 'afficher_competitions.php'; ?>
        </div>
        <div class="form-container">
            <!-- Liste des demandes d'inscription -->
            <h2>Compétitions avec places disponibles</h2>
            <?php include 'afficher_competitions_disponibles.php'; ?>
        </div>  
            </ul>
    <footer>
        <div class="footer">
        <a href="cgu.php">CGU</a>
    </div></footer>
   
</body>
</html>