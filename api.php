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
        $dbCo->beginTransaction();
        $query = $dbCo->prepare("INSERT INTO person(lastname, firstname, email, password) VALUES (:lastname, :firstname, :email, :password);");
        $isQueryOk = $query->execute([
            'lastname' => $data['lastname'],
            'firstname' => $data['firstname'],
            'email' => $data['email'],
            'password' => password_hash($data['pwd'], PASSWORD_DEFAULT)
        ]);
        if ($isQueryOk) {
            $dbCo->commit();
            echo json_encode('Creation done');
        } else {
            $dbCo->rollBack();
            echo json_encode([
                'result' => false,
                'error' => 'Problème lors de la création du compte.'
            ]);
        }
    } catch (Exception $e) {
        $dbCo->rollBack();
        echo json_encode([
            'result' => false,
            'error' => 'Une erreur s\'est produite : ' . $e->getMessage()
        ]);
    }
}

// Connexion with existing account
else if (isset($data['action']) && $data['action'] === 'connexion' && isset($data['email']) && strlen($data['email']) > 0 && isset($data['pwd']) && strlen($data['pwd']) > 5) {
    try {
        $dbCo->beginTransaction();
        $query = $dbCo->prepare('SELECT password FROM person WHERE email = :email;');
        $isQueryOk = $query->execute([
            'email' => $data['email']
        ]);
        if ($isQueryOk) {
            $result = $query->fetch();
            $dbCo->commit();
            if (!password_verify($data['pwd'], $result['password'])) {
                echo json_encode([
                    'result' => false,
                    'error' => 'Ce n\'est pas le bon mot de passe.'
                ]);
                exit;
            } else {
                echo json_encode([
                    'result' => true,
                    'notif' => 'Connexion ok.'
                ]);
            }
        } else {
            $dbCo->rollBack();
            echo json_encode([
                'result' => false,
                'error' => 'Problème lors de la connexion au compte.'
            ]);
        }
    } catch (Exception $e) {
        $dbCo->rollBack();
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