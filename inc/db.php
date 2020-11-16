<?php

try {
	$pdo = new PDO('mysql:host=localhost;dbname=test', 'root', '');
	$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (Exception $e) {
	die("Impossible de se connecter à la base de données.");
}