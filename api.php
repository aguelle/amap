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

// Connexion with an existing account
if (isset($data['action']) && $data['action'] === 'inscription' && isset($data['email']) && strlen($data['email']) > 0 && isset($data['pwd']) && strlen($data['pwd']) > 5) {
    try {
        $dbCo->beginTransaction();
        $query = $dbCo->prepare("INSERT INTO users SET email = :email, hashed_pwd = :hashed_pwd;");
        $isQueryOk = $query->execute([
            'email' => $data['email'],
            'hashed_pwd' => password_hash($data['pwd'], PASSWORD_DEFAULT)
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

// If their is no action available
else {
    echo json_encode([
        'result' => false,
        'error' => 'L\'api n\'a pas executé d\'action.'
    ]);
    exit;
}