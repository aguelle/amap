<?php
require './vendor/autoload.php';
include_once 'includes/_db.php';
include_once './includes/_functions.php';
session_start();
getToken();
if (!isset($_SESSION['id_person'])) {
    $_SESSION['notif'] = 'Vous devez être connecté(e) pour accéder à l\'espace membre.';
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

    <main>
        <div class="flex justify-between">
            <a class="index__link bg-pink" href="action.php?action=deconnexion">Déconnexion</a>
            <a id="pwd-modify__link" class="pwd-modify__link bg-pink" href="">Modifier le mot de passe</a>

            <form id="form__pwd-verify" class="form-member hidden">
                <input id="pwd-verify__id" type="hidden" name="id" value="<?=$_SESSION['id_person']?>">
                <input id="token" type="hidden" name="token" value="<?=$_SESSION['token']?>">
                <input id="pwd-verify__field" type="password" name="pwd-verify" placeholder="Veuillez rentrer votre mot de passe.">
                <input id="pwd-verify__btn" type="submit" value="Confirmer">
            </form>

            <form id="form__pwd-modify" class="form-member hidden">
                <input id="pwd-modify__id" type="hidden" name="id" value="<?=$_SESSION['id_person']?>">
                <input id="token" type="hidden" name="token" value="<?=$_SESSION['token']?>">
                <input id="pwd-modify__field" type="password" name="pwd-verify" placeholder="Renseignez votre nouveau mot de passe.">
                <input id="pwd-modify__btn" type="submit" value="Confirmer">
            </form>

        </div>
        <div class="header__img">
            <img class="member_img" src="assets/img/creamap_2_-removebg-preview.png" alt="logo amap">
        </div>
        <p class="name">
            <?php
            $query = $dbCo->prepare("SELECT firstname, lastname FROM person WHERE id_person = :id_person;");
            $query->execute([
                'id_person' => $_SESSION['id_person']
            ]);
            $result = $query->fetch();
            echo "Bienvenue" . ' ' . $result['firstname'] . '.';
            ?>
        </p>
        <div id="notif-producer" class="notif">
            <?php
            displayNotif();
            ?>
        </div>
        <div class="bg-cream-light member-bg">
            <section>
                <p class="quarter-ttl">
                    <?php
                    $id = $_SESSION['id_person'];
                    $query = $dbCo->prepare("SELECT quarter_number, years
                    FROM distribution
                        JOIN quarter USING (id_quarter)
                        JOIN commitment USING (id_quarter)
                        JOIN subscribe USING (id_commitment)
                        JOIN product USING (id_product)
                        JOIN producer USING (id_producer)
                    WHERE id_producer = :user AND distribution_start > CURDATE() and payment = 1
                    GROUP BY id_distribution LIMIT 1
                    ");
                    $query->execute([
                        'user' => intval($id),
                    ]);
                    $result = $query->fetch();
                    if ($result) echo 'Pour le ' . $result['quarter_number'] . 'e trimestre ' . $result['years'] . ' :';   
                    ?>
                </p>

            </section>
            <section>
                <h2 class="bg-green member_title">A livrer</h2>
                <?php
                    $query = $dbCo->prepare("SELECT product_name, address, producer_name, quantity, distribution_start, distribution_end, id_distribution
                FROM product
                JOIN commitment USING (id_product)
                JOIN subscribe USING (id_commitment)
                JOIN quarter USING (id_quarter)
                JOIN distribution USING (id_quarter)
                JOIN producer USING (id_producer)
                WHERE id_person = :user AND distribution_start > CURDATE() and payment = 1
                GROUP BY id_distribution");

$query->execute([
    'user' => intval($id),
]);
$result = $query->fetchall();

foreach ($result as $product) {
    $distrib = $product['id_distribution'];
    $datetime = date_create($product['distribution_start']);
    $date = date_format($datetime, 'd/m');
    $time1 = date_format($datetime, 'H:i');
    $time2 = date_format(date_create($product['distribution_end']), 'H:i');
    ?>
                   <h3 class="quarter-ttl ">Le <?=$date?> de <?=$time1?> à <?=$time2?>, au <?= $product['address'] ?></h3>

                   <ul class="display">
                   <?php
                    $query = $dbCo->prepare("SELECT product_name, address, producer_name, SUM(quantity) AS totalqty, id_distribution
                FROM product
                JOIN commitment USING (id_product)
                JOIN subscribe USING (id_commitment)
                JOIN quarter USING (id_quarter)
                JOIN distribution USING (id_quarter)
                JOIN producer USING (id_producer)
                WHERE id_person = :user AND id_distribution = :distrib
                GROUP BY id_product");

                    $query->execute([
                        'user' => intval($id),
                        'distrib' => $distrib
                    ]);
                    $result = $query->fetchall();

                    foreach ($result as $product) {
                    ?>

                    
                        <li class="product flex"><?= $product['totalqty'] ?> <?= $product['product_name'] ?></li>

                        <?php
                    }
                    ?>
                </ul>
                    <?php
                    }
                    ?>

            </section>
        </div>
    </main>
        <nav >
            <a href="">
                <div class="profile-page">
                    <img src="assets/img/user-tie-solid.svg" alt="user solid icon" class="nav-icon">
                    <p class="profile-name">Producteur</p>
                </div>
            </a>
            
        </nav>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/producer.js"></script>
</body>

</html>