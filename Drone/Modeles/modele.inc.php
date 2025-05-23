<?php

require_once __DIR__ . '/config.inc.php';

function connexionBdd() {
    try {
        $dsn = 'mysql:host=' . SERVEUR_BDD . ';dbname=' . NOM_DE_LA_BASE;
        $bdd = new PDO($dsn, LOGIN, MOT_DE_PASSE);
        $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $bdd->exec("set names utf8");
        return $bdd;
    } catch (PDOException $ex) {
        echo ('</br>Erreur de connexion au serveur BDD : ' . $ex->getMessage());
        die();
    }
}

function getClasses(PDO $pdo): array {
    $stmt = $pdo->query("SELECT id_classes, nom_classe FROM CLASSES");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function ajouterUtilisateur(PDO $pdo, string $nom, string $prenom, int $id_classes): bool {
    $stmt = $pdo->prepare("INSERT INTO UTILISATEURS (nom, prenom, id_classes) VALUES (:nom, :prenom, :id_classes)");
    return $stmt->execute([
        'nom' => $nom,
        'prenom' => $prenom,
        'id_classes' => $id_classes
    ]);
}

function ajouterClasse(PDO $pdo, string $classe): bool {
    $stmt = $pdo->prepare("INSERT INTO CLASSES (nom_classe) VALUES (:classe)");
    return $stmt->execute(['classe' => $classe]);
}
