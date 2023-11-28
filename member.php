<?php
require './vendor/autoload.php';
include_once 'includes/_db.php';
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
        <div class="header__img">
            <img class="member_img" src="assets/img/creamap_2_-removebg-preview.png" alt="logo amap">
        </div>
        <section>
            <h2 class="bg-green member_title">A récupérer</h2>
        </section>

        <section>
            <h2 class="bg-pink member_title">Abonnements</h2>
            <ul>
                <?php
                $query = $dbCo->prepare("SELECT product_name FROM (product)
        JOIN commitment USING (id_product)
        JOIN subscribe USING (id_commitment)
        JOIN amap_user USING (id_amap_user)
        WHERE id_amap_user = 1;");

                $query->execute();
                $result = $query->fetchall();

                foreach ($result as $product) {
                ?>
                    <li class="product"><?= $product['product_name'] ?></li>

                <?php
                }
                ?>
            </ul>

        </section>
    </main>

    <footer>
        <!-- <img class="img footer__img" src="assets/img/vegetables2.png" alt="panier de légumes"> -->
    </footer>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/script.js"></script>
</body>

</html>