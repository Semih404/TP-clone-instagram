<?php
$mysqlConnection = new PDO(
    'mysql:host=localhost;dbname=clone_insta;charset=utf8',
    'root',
    ''
);
// Récupération des données du formulaire
$pseudo = $_POST['pseudo'];
$password = $_POST['password'];

// Vérification du pseudo
$stmt = $mysqlConnection->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
$stmt->bindParam(':username', $pseudo);
$stmt->execute();

// Vérification si pseudo existe déjà
if($stmt->rowCount() > 0){
    // Pseudo existe déjà, affichage d'un message d'erreur
    echo "Pseudo déjà utilisé, veuillez en choisir un autre.";
} else {
    // Pseudo n'existe pas, ajout des données à la base de données
    $stmt = $mysqlConnection->prepare("INSERT INTO users (pseudo, password) VALUES (:pseudo, :password)");
    $stmt->bindParam(':pseudo', $pseudo);
    $stmt->bindParam(':password', $password);
    $stmt->execute();
    echo "Inscription réussie!";
}
