<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="img/logo.png">
    <title>Galerie</title>
    <style>
        body {
            background-image: url('background2.jpeg'); 
            background-size: cover;
            background-repeat: no-repeat;
            background-attachment: fixed;
            font-family: Arial, sans-serif;
            text-align: center;
            color: #fff;
        }

        h1 {
            font-size: 3em;
            padding: 20px;
        }

        .gallery-table {
            margin: 0 auto;
        }

        .gallery-table img {
            max-width: 300px;
            height: auto;
            margin: 10px;
            border-radius: 10px;
            cursor: pointer;
        }

        .fullscreen-container {
            display: none;
            position: fixed;
            background-color: rgba(0, 0, 0, 0.7);
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            justify-content: center;
            align-items: center;
        }

        .fullscreen-image {
            max-width: 90%;
            max-height: 90%;
            border-radius: 10px;
        }

        .close-button {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 2em;
            cursor: pointer;
        }

        #retour-accueil {
            background-color: #E4FF00;
            color: black;
            padding: 10px 20px;
            text-decoration: none;
            font-size: 1.5em;
            margin-top: 20px;
            margin-bottom: 30px;
            display: inline-block;
            border-radius: 5px;
            cursor: pointer;
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
    <?php
    include 'connexion.php';

    // Récupérer les chemins des images depuis la base de données
    $sql = "SELECT chemin_img FROM galerie";
    $result = $conn->query($sql);

    $images = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = $row["chemin_img"];
        }
    }
    ?>
    <h1>Galerie</h1>
    <a href="index.php" id="retour-accueil">Retour à l'accueil</a>
    <table class="gallery-table">
        <?php
        $rowCount = count($images);
        $imagesPerRow = 3;

        for ($i = 0; $i < $rowCount; $i += $imagesPerRow) {
            echo "<tr>";

            for ($j = 0; $j < $imagesPerRow; $j++) {
                $index = $i + $j;

                if ($index < $rowCount) {
                    echo "<td><img src='" . $images[$index] . "' alt='Image " . ($index + 1) . "' onclick='showFullscreen(\"" . $images[$index] . "\")'></td>";
                } else {
                    echo "<td></td>"; // Ajouter une cellule vide si aucune image disponible
                }
            }

            echo "</tr>";
        }
        ?>
    </table>

    <div class="fullscreen-container" id="fullscreen-container">
        <span class="close-button" onclick="closeFullscreen()">&times;</span>
        <img src="" alt="Fullscreen Image" class="fullscreen-image" id="fullscreen-image">
    </div>

    <script>
        function showFullscreen(imageUrl) {
            const fullscreenContainer = document.getElementById('fullscreen-container');
            const fullscreenImage = document.getElementById('fullscreen-image');

            fullscreenImage.src = imageUrl;
            fullscreenContainer.style.display = 'flex';
        }

        function closeFullscreen() {
            const fullscreenContainer = document.getElementById('fullscreen-container');
            fullscreenContainer.style.display = 'none';
        }
    </script>
    <div class="footer">
        <a href="cgu.php">CGU</a>
    </div>
</body>
</html>
