<?php

// Script pour se connecter à la base commune

try {
    $pdo = new PDO("mysql:host=172.16.216.70;port=3306;dbname=jpo;charset=utf8", 'jpo', 'castor');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);