<?php
require ('connexion.php');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT chemin_img FROM galerie WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("Prepare statement failed: " . $conn->error);
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($chemin_img);
    $stmt->fetch();
    $stmt->close();
    $conn->close();

    if ($chemin_img) {
        if (file_exists($chemin_img)) {
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $mime = finfo_file($finfo, $chemin_img);
            finfo_close($finfo);

            header('Content-Type: ' . $mime);
            readfile($chemin_img);
            exit();
        } else {
            die("Image file does not exist: " . $chemin_img);
        }
    } else {
        die("No image path found for ID: " . $id);
    }
} else {
    die("No ID provided.");
}
?>