<?php
session_start();

require_once __DIR__ . '/../Modeles/modele.inc.php';
require_once __DIR__ . '/../Modeles/modele_utilisateurs.inc.php';

function sendJson($data, $numericCheck = true) {
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, $numericCheck ? JSON_NUMERIC_CHECK : 0);
    exit;
}

$method = filter_input(INPUT_SERVER, 'REQUEST_METHOD');

if ($method === 'GET') {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'getUsers':
            $users = Utilisateur::getAllUsersWithClasse();
            sendJson($users);
            break;

        case 'getClasses':
            $classes = Classe::getAllClasses();
            sendJson($classes);
            break;

        // Exemple possible en GET pour supprimer un utilisateur
        case 'deleteUser':
            $id = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
            if (!$id) {
                sendJson(['success' => false, 'message' => 'ID manquant']);
            }
            $result = Utilisateur::supprimerUtilisateur($id);
            sendJson(['success' => $result]);
            break;

        default:
            sendJson(['success' => false, 'message' => "Action GET inconnue : $action"]);
    }
}

if ($method === 'POST') {
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    switch ($action) {
        case 'ajouterUtilisateur':
            $nom = trim(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING));
            $prenom = trim(filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING));
            $classe = filter_input(INPUT_POST, 'classe', FILTER_SANITIZE_STRING);

            if (!$nom || !$prenom || !$classe) {
                sendJson(['success' => false, 'message' => 'Données invalides']);
            }

            $result = Utilisateur::ajouterUtilisateur($nom, $prenom, $classe);
            sendJson(['success' => $result]);
            break;

        case 'modifierUtilisateur':
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);
            $nom = trim(filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_STRING));
            $prenom = trim(filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_STRING));
            $classe = filter_input(INPUT_POST, 'classe', FILTER_SANITIZE_STRING);

            if (!$id || !$nom || !$prenom || !$classe) {
                sendJson(['success' => false, 'message' => 'Données invalides']);
            }

            $result = Utilisateur::modifierUtilisateur($id, $nom, $prenom, $classe);
            sendJson(['success' => $result]);
            break;

        case 'supprimerUtilisateur':
            $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_NUMBER_INT);

            if (!$id) {
                sendJson(['success' => false, 'message' => 'ID manquant']);
            }

            $result = Utilisateur::supprimerUtilisateur($id);
            sendJson(['success' => $result]);
            break;

        default:
            sendJson(['success' => false, 'message' => "Action POST inconnue : $action"]);
    }
}
