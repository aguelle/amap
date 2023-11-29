<?php
require './vendor/autoload.php';
include_once './includes/_functions.php';

header('content-type:application/json');

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['action'])) {
    echo json_encode([
        'result' => false,
        'error' => 'Aucune action'
    ]);
    exit;
};

include_once './includes/_db.php';

session_start();
checkCSRFAsync($data);
checkXSS($data);

// Creation of an account
if (isset($data['action']) && $data['action'] === 'inscription' && isset($data['email']) && strlen($data['email']) > 0 && isset($data['pwd']) && strlen($data['pwd']) > 5 && isset($data['lastname']) && strlen($data['lastname']) > 0 && isset($data['firstname']) && strlen($data['firstname']) > 0) {

    try {
        $query = $dbCo->prepare('SELECT email FROM person;');
        $query->execute();
        $result = $query->fetchAll();
        foreach($result as $i) {
            if ($i['email'] === $data['email']) {
                echo json_encode([
                    'result' => false,
                    'error' => 'Cette adresse email existe déjà.'
                ]);
                exit;
            };
        };
        $query = $dbCo->prepare("INSERT INTO person(lastname, firstname, email, password) VALUES (:lastname, :firstname, :email, :password);");
        $isQueryOk = $query->execute([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => password_hash($data['pwd'], PASSWORD_DEFAULT)
        ]);
        if ($isQueryOk) {
            $_SESSION['notif'] = 'Votre compte a bien été créé.';
            echo json_encode([
                'result' => true,
                'notif' => 'Creation done',
                'idPerson' => $dbCo->lastInsertId()
            ]);
            $_SESSION['id_person'] = $dbCo->lastInsertId();
        } else {
            echo json_encode([
                'result' => false,
                'error' => 'Problème lors de la création du compte.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'result' => false,
            'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
        ]);
    }
}

// Connexion with existing account
else if (isset($data['action']) && $data['action'] === 'connexion' && isset($data['email']) && strlen($data['email']) > 0 && isset($data['pwd']) && strlen($data['pwd']) > 5) {
    try {
        $query = $dbCo->prepare('SELECT id_person, password FROM person WHERE email = :email;');
        $isQueryOk = $query->execute([
            'email' => $data['email']
        ]);
        if ($isQueryOk) {
            $result = $query->fetchAll();
            if (!isset($result[0])) {
                echo json_encode([
                    'result' => false,
                    'error' => 'L\'adresse email n\'existe pas.'
                ]);
                exit;
            }
            else if (!password_verify($data['pwd'], $result[0]['password'])) {
                echo json_encode([
                    'result' => false,
                    'error' => 'Ce n\'est pas le bon mot de passe.'
                ]);
                exit;
            }           
            else {
                $_SESSION['id_person'] = $result[0]['id_person'];
                $_SESSION['notif'] = 'Vous êtes connecté(e).';
                echo json_encode([
                    'result' => true,
                    'notif' => 'Connexion ok.',
                    'idPerson' => $dbCo->lastInsertId()
                ]);
            }
        } else {
            echo json_encode([
                'result' => false,
                'error' => 'Problème lors de la connexion au compte.'
            ]);
        }
    } catch (Exception $e) {
        echo json_encode([
            'result' => false,
            'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
        ]);
    }
}

// If their is no action available
else {
    echo json_encode([
        'result' => false,
        'error' => 'L\'api n\'a pas executé d\'action.'
    ]);
    exit;
}
