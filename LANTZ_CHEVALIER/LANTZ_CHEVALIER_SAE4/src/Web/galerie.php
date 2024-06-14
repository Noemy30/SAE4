<?php
require('header1.php');
require('connexion.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

<html>

<head>
    <link rel="stylesheet" href="css/galerie.css">
    <link href="https://fonts.googleapis.com/css2?family=Shippori+Mincho&family=Tenor+Sans&display=swap"
        rel="stylesheet" type="text/css">
</head>

<body>
    <?php
    $sql = "SELECT id FROM galerie";
    $result = $conn->query($sql);

    $images = array();

    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $images[] = intval($row["id"]);
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
                    $imageId = $images[$index];
                    echo "<td><img src='image.php?id=" . $imageId . "' alt='Image " . ($index + 1) . "' onclick='showFullscreen(" . $imageId . ")'></td>";
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
        function showFullscreen(imageId) {
            const fullscreenContainer = document.getElementById('fullscreen-container');
            const fullscreenImage = document.getElementById('fullscreen-image');

            fullscreenImage.src = 'image.php?id=' + imageId;
            fullscreenContainer.style.display = 'flex';
        }

        function closeFullscreen() {
            const fullscreenContainer = document.getElementById('fullscreen-container');
            fullscreenContainer.style.display = 'none';
        }
    </script>

    <?php require('footer.php'); ?>
</body>

</html>
