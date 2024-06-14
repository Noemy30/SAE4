<?php
session_start();

// Destruction toutes les données de session
session_destroy();

// Redirection vers la page de connexion
header('Location: login.php');
exit();
?>
