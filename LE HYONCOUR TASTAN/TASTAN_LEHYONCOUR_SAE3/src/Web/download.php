<?php
require ('connexion.php');

if (isset($_GET['id'])) {
    $document_id = intval($_GET['id']);

    $sql = "SELECT img_nom, img_blob FROM document WHERE img_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($img_nom, $img_blob);
        $stmt->fetch();

        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=$img_nom");

        echo $img_blob;
    } else {
        echo "Document non trouvé.";
    }

    $stmt->close();
    $conn->close();
} else {
    echo "ID de document non fourni.";
}
?>