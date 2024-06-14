<?php
include 'connexion.php';

// Vérifiez si l'ID du document est fourni dans l'URL
if (isset($_GET['id'])) {
    $document_id = intval($_GET['id']);

    // Récupérez le nom et le contenu du fichier PDF en fonction de l'ID
    $sql = "SELECT img_nom, img_blob FROM document WHERE img_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $document_id);
    $stmt->execute();
    $stmt->store_result();

    // Vérifiez si le document existe
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($img_nom, $img_blob);
        $stmt->fetch();

        // Définissez les en-têtes pour indiquer que le contenu est un fichier PDF
        header("Content-type: application/pdf");
        header("Content-Disposition: attachment; filename=$img_nom");

        // Affichez le contenu du fichier PDF
        echo $img_blob;
    } else {
        echo "Document non trouvé.";
    }

    // Fermer la connexion et la déclaration préparée
    $stmt->close();
    $conn->close();
} else {
    echo "ID de document non fourni.";
}
?>
