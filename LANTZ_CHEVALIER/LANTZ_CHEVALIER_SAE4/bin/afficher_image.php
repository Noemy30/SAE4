<?php
include 'connexion.php';

// Récupérer l'ID de l'image à afficher depuis la requête GET
if (isset($_GET['img_id'])) {
    $img_id = $_GET['img_id'];

    // Récupérer les données de l'image depuis la base de données
    $sql = "SELECT img_nom, img_blob FROM document WHERE img_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $img_id);

    $stmt->execute();
    $stmt->store_result();

    $stmt->bind_result($img_nom, $img_blob);
    $stmt->fetch();

    // Afficher l'image
    header("Content-type: image");
    echo $img_blob;

    $stmt->close();
} else {
    echo "ID de l'image non spécifié.";
}

$conn->close();
?>
