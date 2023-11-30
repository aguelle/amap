<?php
session_start();
// Deconnexion
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    unset($_SESSION['id_person']);
    $_SESSION['notif'] = 'Vous êtes déconnecté(e).';
    header('Location: index.php');
    exit;
}