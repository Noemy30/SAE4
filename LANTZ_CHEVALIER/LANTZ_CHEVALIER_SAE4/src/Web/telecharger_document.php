<?php
if (isset($_GET['id'])) {
    $id_img = $_GET['id'];
    $sql = "SELECT img_chemin FROM document WHERE id_img = $id_img";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $chemin_fichier = $row["img_chemin"];

        unlink($chemin_fichier);

        $sql_delete = "DELETE FROM document WHERE id_img = $id_img";
        $conn->query($sql_delete);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($chemin_fichier) . '"');
        readfile($chemin_fichier);


        exit();
    } else {
        echo "Document non trouvé.";
    }
} else {
    echo "ID du document non spécifié.";
}

$conn->close();
?>