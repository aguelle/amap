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
        <ul>
            <?php
            $query = $dbCo->prepare("SELECT distribution_start, distribution_end, address
                FROM distribution
                    JOIN quarter USING (id_quarter)
                    JOIN commitment USING (id_quarter)
                    JOIN subscribe USING (id_commitment)
                WHERE id_amap_user = 1 AND id_quarter = 1
                GROUP BY id_distribution;");

            $query->execute();
            $result = $query->fetchall();

            foreach ($result as $distribution) {
                $datetime = date_create($distribution['distribution_start']);
                $date = date_format($datetime, 'd/m/Y');
                $time1 = date_format($datetime, 'H:i');
                $time2 = date_format(date_create($distribution['distribution_end']), 'H:i');
            ?>
                <li class="product">
                    <p>Au <?= $distribution['address'] ?></p>
                    <p>Le <?= $date ?> de <?= $time1 ?> à <?= $time2 ?></p>
                </li>

            <?php
            }
            ?>
        </ul>
        <section>
            <h2 class="bg-pink member_title">Abonnements</h2>
            <ul>
                <?php
var_dump($_SESSION);
                $query = $dbCo->prepare("SELECT product_name FROM (product)
        JOIN commitment USING (id_product)
        JOIN subscribe USING (id_commitment)
        JOIN amap_user USING (id_amap_user)
        WHERE id_person = {$_SESSION['id_person']}");

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