<?php
session_start();
// Deconexion
if (isset($_GET['action']) && $_GET['action'] === 'deconnexion') {
    unset($_SESSION['id_person']);
    header('Location: index.php');
    exit;
}