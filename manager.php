<?php
require 'vendor/autoload.php';
include_once 'includes/_db.php';
include_once 'includes/_functions.php';

session_start();
getToken();
$_SESSION['id_person'] = 139;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/reset.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/manager.css">
    <title>CreAmap</title>
</head>

<body class="manager-body">
    <a class="index__link bg-pink" href="action.php?action=deconnexion">Déconnexion</a>
    <a id="pwd-modify__link" class="pwd-modify__link bg-pink" href="">Modifier le mot de passe</a>
    <header class="manager-header">
        <?php
        $displayName = $dbCo->prepare('SELECT firstname FROM person WHERE id_person = :id;');
        $displayName->execute([
            'id' => $_SESSION['id_person']
        ]);
        $name = $displayName->fetchColumn();
        ?>
        <div class="header-content">
            <h1 class="hidden">CreAmap</h1>
            <img src="assets/img/creamap_2_-removebg-preview.png" alt="CreAmap second logo" class="scnd-logo">
            <h2 class="welcome-txt">Bienvenue <?= $name ?></h2>
        </div>
        <div id="notif-producer" class="notif">
            <?php
            displayNotif();
            ?>
        </div>
    </header>
    <main class="manager-main">
        <section class="growers-cntnr" id="growers">
            <?php
            $query = $dbCo->prepare('SELECT id_amap_user FROM amap_user WHERE id_person = :id;');
            $query->execute([
                'id' => $_SESSION['id_person']
            ]);
            $idUser = $query->fetchColumn();

            $displayGrowers = $dbCo->prepare('SELECT id_producer, producer_name FROM producer JOIN manage USING (id_producer) WHERE id_amap_user = :id ORDER BY id_producer DESC;');
            $displayGrowers->execute([
                'id' => $idUser
            ]);
            $growers = $displayGrowers->fetchAll();

            foreach ($growers as $grower) {
            ?>
                <div class="display">
                    <div class="title-cntnr">
                        <div class="title">
                            <h3 class="title-txt"><?= $grower['producer_name'] ?></h3>
                        </div>
                        <button class="product-btn">
                            <div class="add-product">
                                <img src="assets/img/plus-solid.svg" alt="plus solid icon" class="add-icon">
                            </div>
                        </button>
                    </div>
                    <div class="list-cntnr">
                        <ul class="list-content">
                            <?php
                            $displayProducts = $dbCo->prepare('SELECT id_product, product_name, SUM(quantity) AS ttl_qty FROM product JOIN commitment USING (id_product) JOIN subscribe USING (id_commitment) WHERE id_producer = :id GROUP BY id_commitment;');
                            $displayProducts->execute([
                                'id' => $grower['id_producer']
                            ]);
                            $products = $displayProducts->fetchAll();

                            foreach ($products as $product) {
                            ?>
                                <li data-id-product="<?= $product['id_product'] ?>" class="product-cntnr">
                                    <h4 class="product-title"><?= $product['ttl_qty'] ?> <?= $product['product_name'] ?></h4>
                                    <div class="icons-cntnr">
                                        <button class="edit-btn" id="editBtn">
                                            <img src="assets/img/pencil-solid.svg" alt="pencil solid logo" class="icon">
                                        </button>
                                        <button class="delete-btn" id="deleteBtn">
                                            <img src="assets/img/trash-can-solid.svg" alt="trash can solid logo" class="icon">
                                        </button>
                                    </div>
                                </li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            <?php } ?>
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
    <template id="growerTemplate">
        <div class="display">
            <div class="title-cntnr">
                <div class="title">
                    <h3 class="title-txt" data-content="business"></h3>
                </div>
                <button class="product-btn">
                    <div class="add-product">
                        <img src="assets/img/plus-solid.svg" alt="plus solid icon" class="add-icon">
                    </div>
                </button>
            </div>
            <div class="list-cntnr">
                <ul class="list-content">

                </ul>
            </div>
        </div>
    </template>
    <script src="assets/js/functions.js"></script>
    <script src="assets/js/manager.js"></script>
</body>

</html>