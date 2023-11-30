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
        <div id="notif-member" class="notif">
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
                    WHERE id_amap_user = :user AND distribution_start > CURDATE() and payment = 1
                    GROUP BY id_distribution LIMIT 1
                    ");     
                    $query->execute([
                        'user' => intval($id),
                    ]);
                    $result = $query->fetch();
                    if ($result) echo 'Pour le ' . $result['quarter_number'] . 'e trimestre ' . $result['years'] . ' :';                
                ?>
            </p>
            <h2 class="bg-green member_title">A récupérer</h2>
            <ul>
            <?php
            $id = $_SESSION['id_person'];
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
                <li class="distrib">
                    <p>Au <?= $distribution['address'] ?></p>
                    <p>Le <?= $date ?> de <?= $time1 ?> à <?= $time2 ?></p>
                </li>

            <?php
            }
            ?>
        </ul>
        </section>
        <section>
            <h2 class="bg-green member_title">Abonnements</h2>
            <ul class="flex">
                <?php
                $query = $dbCo->prepare("SELECT quantity, product_name FROM (product)
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
                    <li class="product flex "><?= $product['quantity'] ?> <?= $product['product_name'] ?></li>

                <?php
                }
                ?>
            </ul>

        </section>
            </div>
    </main>

    <script src="./assets/js/functions.js"></script>
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/member.js"></script>
</body>

</html>