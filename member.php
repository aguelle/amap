<?php
require './vendor/autoload.php';
include_once 'includes/_db.php';
include_once './includes/_functions.php';
session_start();
getToken();
if (!isset($_SESSION['id_person'])) {
    header('location: index.php');
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
    <?php
        include 'header.php';
    ?>
    <main>
        <div class="header__img">
            <img class="member_img" src="assets/img/creamap_2_-removebg-preview.png" alt="logo amap">
        </div>
        <div id="notif-member" class="notif">
            <?php
                displayNotif();
            ?>
        </div>
        <section>
            <h2 class="bg-green member_title">A récupérer</h2>
        </section>
        <ul>
            <?php
            $id = $_SESSION['id_person'];
            var_dump($id);
            $query = $dbCo->prepare("SELECT distribution_start, distribution_end, address
            FROM distribution
                JOIN quarter USING (id_quarter)
                JOIN commitment USING (id_quarter)
                JOIN subscribe USING (id_commitment)
            WHERE id_amap_user = :user AND distribution_start > CURDATE() and payment = 1
            GROUP BY id_distribution LIMIT 1
            ");

            $query->execute([
                'user' => intval($id),

            ]);
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
                var_dump($id);
                $query = $dbCo->prepare("SELECT product_name FROM (product)
                JOIN commitment USING (id_product)
                JOIN quarter USING (id_quarter)
                JOIN subscribe USING (id_commitment)
                JOIN amap_user USING (id_amap_user)
                WHERE id_person = :user AND CURDATE() BETWEEN start_date AND end_date AND payment = 1
                GROUP BY id_product");

                $query->execute([
                    'user' => intval($id)
                ]);
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

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/script.js"></script>
</body>

</html>