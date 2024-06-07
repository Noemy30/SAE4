<?php
include 'connexion.php';

if (isset($_GET['id'])) {
    $id_img = $_GET['id'];

    // Récupérer le chemin du fichier depuis la base de données
    $sql = "SELECT img_chemin FROM document WHERE id_img = $id_img";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $chemin_fichier = $row["img_chemin"];

        // Supprimer le fichier du dossier
        unlink($chemin_fichier);

        // Supprimer l'entrée de la base de données
        $sql_delete = "DELETE FROM document WHERE id_img = $id_img";
        $conn->query($sql_delete);

        // Envoi du fichier au navigateur pour téléchargement
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($chemin_fichier) . '"');
        readfile($chemin_fichier);

        // Arrêter l'exécution du script après le téléchargement
        exit();
    } else {
        echo "Document non trouvé.";
    }
} else {
    echo "ID du document non spécifié.";
}

$conn->close();
?>
