<?php
// nom d'utilisateur de la BDD 
$login = 'root';
// Mot de pass de la BDD
$password ='';
// nom de la BDD
$database = 'descodeuses_presentation';
// Adresse du serveur
$host ='localhost';
//connexion à la BDD
$connexion= mysqli_connect($host, $login, $password, $database) or 
die(mysqli_connect_error($connexion));

