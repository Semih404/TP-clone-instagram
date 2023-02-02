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

    // Prepare and execute the SQL statement to select the user with the entered username
    $query = $mysqlConnection->prepare("SELECT * FROM users WHERE pseudo = :pseudo");
    $query->bindParam(':pseudo', $pseudo);
    $query->execute();

    $user = $query->fetch();

    // Check if the username exists in the database
    if($query->rowCount() > 0){
        // Check if the entered password matches password in the database
        if($password == $user['password']) {
            echo "Connexion réussie";
            header('Location: fyp.php');
            exit();
        } else {
            // Incorrect password
            echo "Pseudo et/ou mot de passe incorrect.";
        }
    } else {
        // Username does not exist in the database
        echo "Pseudo et/ou mot de passe incorrect.";
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
    <form action="page_connexion.php" method="post">
        Pseudo : <input type="text" name="pseudo"><br>
        Password : <input type="password" name="password"><br>
        <input type="submit" value="soumettre">
    </form>
</body>
</html>
