<?php
require ('header1.php');
require ('connexion.php');

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        $img_nom = $_FILES["image"]["name"];
        $img_type = $_FILES["image"]["type"];
        $img_taille = $_FILES["image"]["size"];
        $img_tmp = $_FILES["image"]["tmp_name"];

        $dossier = 'documentAdmin/';
        $chemin_fichier = $dossier . basename($img_nom);

        if (move_uploaded_file($img_tmp, $chemin_fichier)) {
            $sql = "INSERT INTO document_administratif (nom_fich, chemin_fich) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ss", $img_nom, $chemin_fichier);

            if ($stmt->execute()) {
                $error_message = "Document téléchargé avec succès.";
            } else {
                $error_message = "Erreur lors du téléchargement du document.";
            }
            $stmt->close();
        } else {
            $error_message = "Erreur lors du déplacement du fichier.";
        }
    } else {
        $error_message = "Aucun fichier sélectionné ou une erreur est survenue.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Club de Tennis</title>
    <link href="css/admin.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>
    <div class="title">
        <header>
            <h1>MENU ADMINISTRATEUR</h1>
        </header>
    </div>

    <section class="container">
        <div class="col1">
            <div class="form-container">
                <h2>Ajouter une compétition</h2>
                <div class="ajouter">
                    <form action="ajouter_competition.php" method="post">
                        <label for="lieu">Lieu :</label>
                        <input type="text" name="lieu" required>
                        <br>
                        <label for="horaire">Horaire :</label>
                        <input type="datetime-local" id="horaire" name="horaire" required>
                        <br>
                        <label for="joueurs_necessaires">Nombre de joueurs nécessaires :</label>
                        <input type="number" name="joueurs_necessaires" required min="6">
                        <br>
                        <label for="places_disponibles">Places disponibles :</label>
                        <input type="number" name="places_disponibles" required pattern="\d+">
                        <br>
                        <input type="submit" value="Ajouter Compétition" class="button">
                    </form>
                </div>
            </div>

            <div class="form-container">
                <h2>Liste des Compétitions</h2>
                <table class="competition-table">
                    <thead>
                        <tr>
                            <th>Lieu</th>
                            <th>Horaire et Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $sql = "SELECT lieu, horaire FROM competitions";
                        $result = $conn->query($sql);
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['lieu']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['horaire']) . "</td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='2'>Aucune compétition trouvée</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>

            <div class="derniereBox">
                <div class="form-container">
                    <div class="telechargerFichier">
                        <h2>Fichier disponible au téléchargement</h2>
                        <?php
                        $sql = "SELECT id_img, img_nom, img_chemin FROM document";
                        $result = $conn->query($sql);
                        if ($result && $result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<a href='telecharger_document.php?id=" . $row["id_img"] . "'>Télécharger Document " . htmlspecialchars($row["img_nom"]) . "</a><br>";
                            }
                        } else {
                            echo "Aucun document trouvé.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col2">
            <div class="form-container">
                <h2>Ajouter un document administratif</h2>
                <form action="admin.php" method="post" enctype="multipart/form-data">
                    <label for="image">Choisir un fichier :</label>
                    <input type="file" name="image" accept="image/*" required>
                    <br>
                    <input type="submit" value="Télécharger" class="button">
                </form>
                <?php if (!empty($error_message))
                    echo '<p class="error-message">' . $error_message . '</p>'; ?>
            </div>


            <div class="form-container">
                <h2>Ajouter une image à la galerie</h2>
                <form action="uploadgalerie.php" method="post" enctype="multipart/form-data">
                    <label for="image">Choisir une image :</label>
                    <input type="file" name="image" accept="image/*" required>
                    <br>
                    <input type="submit" value="Télécharger">
                </form>
            </div>


            <div class="form-container">
                <h2>Voir la liste des adhérents</h2>
                <a href="liste_adherents.php" class="button">Liste des adhérents</a>
            </div>
        </div>
    </section>


    <script src="script/date.js"></script>

    <?php
    require ('footer.php');
    ?>
</body>

</html>

<?php
$conn->close();
?>