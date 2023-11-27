<?php
require './vendor/autoload.php';
// include_once 'includes/_db.php';
include_once './includes/_functions.php';
session_start();
getToken();
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Creamap</title>
</head>

<body>

    <main>
        <img class="img header__img" src="assets/img/amap-logo.png" alt="logo amap">
        <h1>Creamap Hérouville</h1>
        <section>
            <form class="flex column align-center">
                <input type="email" name="email" placeholder="Email">
                <input type="text" name="password" placeholder="Mot de passe">
                <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
                <input class="bg-green" type="submit" value="Connexion">
            </form>
        </section>
    </main>

    <footer>
        <img class="img footer__img" src="assets/img/maxresdefault.webp" alt="panier de légumes">
    </footer>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/script.js"></script>
</body>

</html>