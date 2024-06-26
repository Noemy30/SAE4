<?php
require ('header1.php');
require ('connexion.php');

$conn->set_charset('utf8mb4');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nom_utilisateur = htmlspecialchars($_POST["nom_utilisateur"], ENT_QUOTES, 'UTF-8');
    $mot_de_passe = htmlspecialchars($_POST["mot_de_passe"], ENT_QUOTES, 'UTF-8');

    $sql = "SELECT * FROM admin WHERE nom_utilisateur = ? AND mdp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('ss', $nom_utilisateur, $mot_de_passe);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $_SESSION['is_admin'] = true;
        $_SESSION['last_activity'] = time();
    } else {
        echo "<p style='color: red;'>Nom d'utilisateur ou mot de passe incorrect.</p>";
    }

    $stmt->close();
    $conn->close();
}

if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
    header('Location: index.php');
    exit();
}

if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
    session_unset();
    session_destroy();
    header('Location: index.php');
    exit();
}

$_SESSION['last_activity'] = time();
?>


<html>

<head>
    <title>Liste des adhérents</title>
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
    <link href="css/liste.css" rel="stylesheet" />
</head>

<body>

    <div class="adherents-container">
        <h2>Liste des adhérents</h2>

        <table>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Niveau de pratique</th>
                <th>ID de la compétition</th>
                <th>Action Modifier</th>
                <th>Action Supprimer</th>
            </tr>
            <?php
            require ('connexion.php');
            $conn->set_charset('utf8mb4');

            $sql = "SELECT ID, Nom, Prenom, Niveau FROM membre";
            $result = $conn->query($sql);

            if ($result && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row["Nom"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["Prenom"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["Niveau"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td>" . htmlspecialchars($row["ID"], ENT_QUOTES, 'UTF-8') . "</td>";
                    echo "<td><a href='modifier_membre.php?id=" . htmlspecialchars($row["ID"], ENT_QUOTES, 'UTF-8') . "'>Modifier</a></td>";
                    echo "<td><a href='supprimer_membre.php?id=" . htmlspecialchars($row["ID"], ENT_QUOTES, 'UTF-8') . "'>Supprimer</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Aucun adhérent trouvé</td></tr>";
            }

            $conn->close();
            ?>
        </table>

    </div>
    <?php
    require ('footer.php');
    ?>
</body>

</html>