<?php
require ('header1.php');
require ('connexion.php');

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom = htmlspecialchars($_POST["nom"]);
    $prenom = htmlspecialchars($_POST["prenom"]);
    $age = htmlspecialchars($_POST["age"]);
    $ville = htmlspecialchars($_POST["ville"]);
    $password = htmlspecialchars($_POST["password"]);

    $verifRequete = "SELECT * FROM Membre WHERE Nom='$nom' AND Prenom='$prenom' AND password='$password'";
    $result = $conn->query($verifRequete);

    if ($result->num_rows > 0) {
        $error_message = "Un membre avec ce nom, prénom ou mot de passe existe déjà.";
    } else {
        $requete = "INSERT INTO Membre (Nom, Prenom, Age, Ville, password) VALUES ('$nom', '$prenom','$age','$ville','$password')";

        if ($conn->query($requete) === TRUE) {
            $success_message = "Enregistrement réussi !";
        } else {
            $error_message = "Erreur lors de l'enregistrement : " . $conn->error;
        }
    }
}

$conn->close();
?>

<html>

<head>
    <title>Inscription</title>
    <link href="css/formuInscri.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
    <script>
        function validateForm() {
            const nameRegex = /^[A-Za-z]+$/;
            const numberRegex = /^[0-9]+$/;
            const age = document.getElementById("age").value;
            const nom = document.getElementById("nom").value;
            const prenom = document.getElementById("prenom").value;

            if (!nameRegex.test(nom)) {
                alert("Le nom doit contenir uniquement des lettres.");
                return false;
            }

            if (!nameRegex.test(prenom)) {
                alert("Le prénom doit contenir uniquement des lettres.");
                return false;
            }

            if (!numberRegex.test(age) || age < 13) {
                alert("L'âge doit être un nombre et ne peut pas être inférieur à 13 ans.");
                return false;
            }

            return true;
        }
    </script>
</head>

<body>
    <div class="form-container">

        <?php
        if (!empty($error_message)) {
            echo "<div class='message-error'>$error_message</div>";
        }
        if (!empty($success_message)) {
            echo "<div class='message-success'>$success_message</div>";
        }
        ?>
        
        <h2>S'inscrire en tant que membre</h2>

        <form action="formulaire_inscription.php" method="post" onsubmit="return validateForm()">
            <div class="formulaire">
                <label for="nom">Nom:</label>
                <input type="text" id="nom" name="nom" required><br>

                <label for="prenom">Prénom:</label>
                <input type="text" id="prenom" name="prenom" required><br>

                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required><br>

                <label for="ville">Ville:</label>
                <input type="text" id="ville" name="ville"><br>

                <label for="password">Mot de passe:</label>
                <input type="text" id="password" name="password" required><br>
            </div>

            <div class="btn">
                <input type="submit" value="Ajouter">
            </div>
        </form>
    </div>

    <?php
    require ('footer.php');
    ?>
</body>

</html>