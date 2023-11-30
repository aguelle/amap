<?php
require './vendor/autoload.php';
include_once 'includes/_db.php';
include_once './includes/_functions.php';
session_start();
getToken();
if (isset($_SESSION['id_person'])) {
    $_SESSION['notif'] = 'Vous devez vous déconnecter pour revenir à l\'accueil.';
    header('location: member.php');
};
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
    <div class="header__img">
            <img class="img" src="assets/img/creamap_2_-removebg-preview.png" alt="logo amap">
        </div>
        <h1></h1>
        <div id="notif-index" class="notif">
            <?php
                displayNotif();
            ?>
        </div>
        <section>
            <form id="inscription" class="form flex column align-center justify-between hidden">
                <input id="insc__lastname" type="text" name="lastname" placeholder="Nom" required>
                <input id="insc__firstname" type="text" name="firstname" placeholder="Prénom" required>
                <input id="insc__email" type="email" name="email" placeholder="Email" required>
                <input id="insc__pwd" type="password" name="password" placeholder="Mot de passe" required>
                <input id="insc__btn" class="bg-pink insc__btn" type="submit" value="Créer le compte">
                <button id="index-back__btn" class="index-back__btn bg-pink">Retour</button>
            </form>
            <form id="connexion" class="form flex column align-center justify-between">
                <input id="conn__email" type="email" name="email" placeholder="Email" required>
                <input id="conn__pwd" type="password" name="password" placeholder="Mot de passe" required>
                <input id="token" type="hidden" name="token" value="<?=$_SESSION['token']?>">
                <input id="conn__btn" class="bg-pink conn__btn" type="submit" value="Se connecter">
                <p class="suscribe">Vous n'avez pas de compte ? <a href="#" id="create__link" class="create__link">Inscrivez-vous</a></p>
            </form>
            <div class="switch-container flex">
                <P>Vous êtes producteur ?</p>
                <label class="switch">
                    <input id="switch" type="checkbox">
                    <span></span>
                </label>
            </div>
        </section>
    </main>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/index.js"></script>
</body>

</html>