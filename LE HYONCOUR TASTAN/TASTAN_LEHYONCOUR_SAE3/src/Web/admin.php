<?php
require ('header1.php');
require ('connexion.php');

// Initialisation des variables
$error_message = '';

// Vérifier si le formulaire de téléchargement de document a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Vérifier si un fichier a été téléchargé
    if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
        // Récupérer les informations du fichier
        $img_nom = $_FILES["image"]["name"];
        $img_type = $_FILES["image"]["type"];
        $img_taille = $_FILES["image"]["size"];
        $img_tmp = $_FILES["image"]["tmp_name"];

        // Définir le chemin du dossier où les fichiers seront enregistrés
        $dossier = 'documentAdmin/';
        $chemin_fichier = $dossier . basename($img_nom);

        // Enregistrer le fichier dans le dossier
        if (move_uploaded_file($img_tmp, $chemin_fichier)) {
            // Insérer le chemin du fichier dans la base de données
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
                        <input type="datetime-local" name="horaire" required>
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
                <h2>Voir la liste des adhérents</h2>
                <a href="liste_adherents.php" class="button">Liste des adhérents</a>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            // Set the minimum date to today
            const today = new Date().toISOString().split('T')[0];
            document.querySelector('input[type="datetime-local"]').setAttribute('min', today);

            // Add form validation
            document.querySelector('form').addEventListener('submit', function (event) {
                const joueurs_necessaires = document.querySelector('input[name="joueurs_necessaires"]').value;
                const places_disponibles = document.querySelector('input[name="places_disponibles"]').value;
                let isValid = true;
                let errorMessage = '';

                // Check number of players
                if (joueurs_necessaires <= 5) {
                    isValid = false;
                    errorMessage += 'Le nombre de joueurs nécessaires doit être supérieur à 5.\n';
                }

                // Check places available
                if (!/^\d+$/.test(places_disponibles)) {
                    isValid = false;
                    errorMessage += 'Les places disponibles doivent être un nombre.\n';
                }

                if (!isValid) {
                    event.preventDefault();
                    alert(errorMessage);
                }
            });
        });
    </script>

    <?php
    require ('footer.php');
    ?>
</body>

</html>

<?php
$conn->close();
?>