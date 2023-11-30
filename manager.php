<?php
require 'vendor/autoload.php';
include_once 'includes/_db.php';
include_once 'includes/_functions.php';

session_start();
getToken();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>CreAmap</title>
</head>

<body class="manager-body">
    <header class="manager-header">
        <div class="header-content">
            <h1 class="hidden">CreAmap</h1>
            <img src="assets/img/creamap_2_-removebg-preview.png" alt="CreAmap second logo" class="scnd-logo">
            <h2 class="welcome-txt">Bienvenue (Prénom)</h2>
        </div>
    </header>
    <main class="manager-main">
        <section class="display">
            <div class="title-cntnr">
                <div class="title">
                    <h3 class="title-txt">(Nom Entreprise)</h3>
                </div>
                <button class="product-btn">
                    <div class="add-product">
                        <img src="assets/img/plus-solid.svg" alt="plus solid icon" class="add-icon">
                    </div>
                </button>
            </div>
            <div class="list-cntnr">
                <ul class="list-content">
                    <li class="product-cntnr">
                        <h4 class="product-title">(Qty ttl) (Nom Produit)</h4>
                        <div class="icons-cntnr">
                            <button class="edit-btn">
                                <img src="assets/img/pencil-solid.svg" alt="pencil solid logo" class="icon">
                            </button>
                            <button class="delete-btn">
                                <img src="assets/img/trash-can-solid.svg" alt="trash can solid logo" class="icon">
                            </button>
                        </div>
                    </li>
                </ul>
            </div>
        </section>
        <section class="add">
            <button class="grower-btn" id="displayGrowerForm">
                <div class="add-grower">
                    <p class="add-txt">Ajouter un producteur</p>
                    <img src="assets/img/plus-solid.svg" alt="plus solid icon" class="add-icon">
                </div>
            </button>
        </section>
        <form action="" class="add-form hidden" id="growerForm">
            <div class="inputs-cntnr">
                <input type="text" id="lastname" name="lastname" placeholder="Nom" class="input">
                <input type="text" id="firstname" name="firstname" placeholder="Prénom" class="input">
                <input type="email" id="email" name="email" placeholder="E-mail" class="input">
                <input type="text" id="business" name="business" placeholder="Nom de l'entreprise" class="input">
                <input type="hidden" id="token" name="token" value="<?= $_SESSION['token'] ?>">
            </div>
            <input type="submit" id="addGrower" value="Ajouter" class="add-submit">
        </form>
        <nav class="manager-nav">
            <a href="member.php">
                <div class="profile-page">
                    <img src="assets/img/user-large-solid.svg" alt="user solid icon" class="nav-icon">
                    <p class="profile-name">Adhérent</p>
                </div>
            </a>
            <a href="#">
                <div class="profile-page active">
                    <img src="assets/img/user-group-solid.svg" alt="user group solid icon" class="nav-icon">
                    <p class="profile-name">Responsable</p>
                </div>
            </a>
        </nav>
    </main>
    <script src="./assets/js/functions.js"></script>
    <script src="manager.js"></script>
</body>

</html>