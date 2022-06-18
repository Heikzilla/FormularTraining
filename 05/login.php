<?php
require_once('class/User.php');
session_start();

$user = new User();

if (strlen(trim($_POST['email'])) == 0){
    $_SESSION['error']['email'] = "Email ist Pflichtfeld! Bitte ausfüllen!";
}

if (strlen(trim($_POST['password'])) == 0){
    $_SESSION['error']['password'] = "Password ist Pflichtfeld! Bitte ausfüllen!";
}



if(!isset($_SESSION['error'])){

    $email = $_POST['email'];
    $pw1 = $_POST['password'];

    $user->setEmail($email);
    $user->setPassHash($pw1);

    if ($user->checkPassword()){
        $_SESSION['nickname'] = $user->getNickname();
        $_SESSION['login'] = true;

        header('Location: index.php');
        #printf( 'Valides Passwort.');
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
<form action="login.php" method="post">
    <label>Email: </label>
    <input name="email" id="email" type="email"><br>
    <label>Passwort: </label>
    <input name="password" id="password" type="password"><br>
    <input type="submit" value="submit">
</form>
</body>
</html>
