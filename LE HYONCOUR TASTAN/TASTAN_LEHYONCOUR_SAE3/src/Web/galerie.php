<?php
require ('header1.php');
require ('connexion.php'); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<head>
    <link rel="stylesheet" href="css/galerie.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>
    <?php
    $sql = "SELECT chemin_img FROM galerie";
    $result = $conn->query($sql);

    $images = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = htmlspecialchars($row["chemin_img"], ENT_QUOTES, 'UTF-8'); 
        }
    } else {
        echo "No images found or an error occurred.";
    }
    ?>
    <h1>Galerie</h1>

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
                    echo "<td></td>";
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

    <?php require ('footer.php'); ?>
</body>

</html>