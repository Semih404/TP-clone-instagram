<?php
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$mysqlConnection = new PDO(
    'mysql:host=localhost;dbname=clone_insta;charset=utf8',
    'root',
    ''
);

if(isset($_POST['pseudo']) && isset($_POST['password'])){
    $pseudo = $_POST['pseudo'];
    $password = $_POST['password'];

    // Vérification de l'existence du pseudo
    $query = $mysqlConnection->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
    $query->bindParam(':pseudo', $pseudo);
    $query->execute();
    print_r($query->errorInfo());
    
    $user = $query->fetch();

    // Vérification si le pseudo existe déjà
    if($query->rowCount() > 0){
        // Pseudo existe déjà, affichage d'un message d'erreur
        echo "Pseudo déjà utilisé, veuillez en choisir un autre.";
    } else {
        // Pseudo n'existe pas, ajout des données à la base de données
        $query = $mysqlConnection->prepare("INSERT INTO users (id, pseudo, password) VALUES (null, :pseudo, :password)");
        $query->bindParam(':pseudo', $pseudo, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        if ($query->execute()) {
          echo "Inscription réussie!";
          header('Location: fyp.php');
          exit();
        }
    }
} else {
    // Affiche un message d'erreur si les variables $_POST sont manquantes
    echo 'Les variables $_POST sont manquantes';
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exercice</title>
</head>
<body>
    <form action="page_inscription.php" method="post">
        Pseudo : <input type="text" name="pseudo"><br>
        Password : <input type="password" name="password"><br>
        <input type="submit" value="soumettre">
    </form>
</body>
</html>
