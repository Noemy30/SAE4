<?php
require ('header1.php')
    ?>
<html>

<head>
    <title>Inscription</title>
    <link href="css/inscription.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>


    <div class="form-container">
        <h2>S'inscrire en tant que membre</h2>

        <form action="formulaire_inscription.php" method="post">
            <div class="formulaire">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom"><br>

                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom"><br>

                <label for="niveau_pratique">Niveau de pratique:</label>
                <input type="text" id="niveau_pratique" name="niveau_pratique"><br>

                <label for="age">Age:</label>
                <input type="text" id="age" name="age"><br>

                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville"><br>

                <label for="competition_id">Numéro de licence:</label>
                <input type="text" id="competition_id" name="competition_id"><br>

                <label for="password">Mot de passe:</label>
                <input type="text" id="password" name="password"><br>
            </div>


            <div class="btn">
                <input type="submit" value="Ajouter">
            </div>

        </form>
        <?php
        // Connexion à la base de données (remplacez ces informations par vos propres paramètres)
        $serveur = "localhost";
        $utilisateur = "root";
        $mot_de_passe = "";
        $base_de_donnees = "club_tennis";

        $connexion = new mysqli($serveur, $utilisateur, $mot_de_passe, $base_de_donnees);

        // Vérifier la connexion à la base de données
        if ($connexion->connect_error) {
            die("Échec de la connexion à la base de données : " . $connexion->connect_error);
        }

        // Traitement du formulaire lorsque soumis
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération des valeurs du formulaire
            $nom = htmlspecialchars($_POST["nom"]);
            $prenom = htmlspecialchars($_POST["prenom"]);
            $niveau_pratique = htmlspecialchars($_POST["niveau_pratique"]);
            $age = htmlspecialchars($_POST["age"]);
            $ville = htmlspecialchars($_POST["ville"]);
            $competition_id = htmlspecialchars($_POST["competition_id"]);
            $password = htmlspecialchars($_POST["password"]);

            // Requête SQL pour insérer les données dans la table
            $requete = "INSERT INTO Membre (ID, Nom, Prenom, Age, Niveau, Ville, password ) VALUES ('$competition_id', '$nom', '$prenom','$age', '$niveau_pratique','$ville','$password')";

            // Exécution de la requête
            if ($connexion->query($requete) === TRUE) {
                echo "Enregistrement réussi !";
            } else {
                echo "Erreur lors de l'enregistrement : " . $connexion->error;
            }
        }

        // Fermer la connexion à la base de données
        $connexion->close();
        ?>

    </div>

    <?php
    require ('footer.php')
        ?>
</body>

</html>