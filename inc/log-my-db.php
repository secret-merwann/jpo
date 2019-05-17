<?php

// Script pour se connecter à la base personnelle

try {
    $pdomydb = new PDO("mysql:host=127.0.0.1;port=3306;dbname=jpo;charset=utf8", 'root', '');
} catch (PDOException $e) {
    print "Erreur !: " . $e->getMessage() . "<br/>";
    die();
}
$pdomydb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdomydb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);