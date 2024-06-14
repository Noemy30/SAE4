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

    error_log("Password received: $password");

    // Validation du mot de passe côté serveur
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/', $password)) {
        $error_message = "Le mot de passe doit contenir au moins 12 caractères, avec au moins une minuscule, une majuscule, un chiffre et un caractère spécial.";
    } else {

        $verifRequete = "SELECT * FROM Membre WHERE Nom='$nom' AND Prenom='$prenom'";
        $result = $conn->query($verifRequete);

        if ($result->num_rows > 0) {
            $error_message = "Un membre avec ce nom et prénom existe déjà.";
        } else {
            if (function_exists('openssl_random_pseudo_bytes')) {
                $salt = bin2hex(openssl_random_pseudo_bytes(16));
            } else {
                $salt = bin2hex(mt_rand());
            }

            $salted_password = $salt . $password;
            $hashed_password = password_hash($salted_password, PASSWORD_BCRYPT);

            $requete = "INSERT INTO Membre (Nom, Prenom, Age, Ville, salt, password) VALUES ('$nom', '$prenom','$age','$ville','$salt','$hashed_password')";

            if ($conn->query($requete) === TRUE) {
                $success_message = "Enregistrement réussi !";
            } else {
                $error_message = "Erreur lors de l'enregistrement : " . $conn->error;
            }
        }
    }
}

$conn->close();
?>

<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription</title>
    <link href="css/formuInscri.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
    <script>
        function validateForm() {

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

                <input type="password" id="password" name="password" required><br>
            </div>

            <div class="btn">
                <input type="submit" value="Ajouter">
            </div>
        </form>
    </div>

    <?php
    require ('footer.php');
    ?>

    <script>
        function validateForm() {
            const nameRegex = /^[A-Za-z]+$/;
            const numberRegex = /^[0-9]+$/;
            const passwordRegex = String;
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{12,}$/;

            const age = document.getElementById("age").value;
            const nom = document.getElementById("nom").value;
            const prenom = document.getElementById("prenom").value;


            const password = document.getElementById("password").value;

            console.log("Password entered:", password);

            if (!passwordRegex.test(password)) {
                alert("Le mot de passe doit contenir au moins 12 caractères, avec au moins une minuscule, une majuscule, un chiffre et un caractère spécial.");
                return false;
            }

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

</body>

</html>