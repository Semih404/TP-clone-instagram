<?php
$mysqlConnection = new PDO(
    'mysql:host=localhost;dbname=clone_insta;charset=utf8',
    'root',
    ''
);
$pseudo = $_POST['pseudo'];
$password = $_POST['password'];

$query = "SELECT password FROM users WHERE pseudo = '$pseudo'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (password_verify($password, $user['password'])) {
    // mot de passe est valide
    header('Location: fyp.php');
    exit();
} else {
    // mot de passe est invalide
        echo '<script language="javascript">';
        echo 'alert("Pseudo ou/et mot de passe incorrect")';
        echo '</script>';
        header('Location: '.$_SERVER['REQUEST_URI']);
}

?>