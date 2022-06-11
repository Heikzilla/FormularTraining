<?php
session_start();

print_r($_SESSION);
if(!isset($_SESSION['login'])){
    header("Location: login.php");
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Welcome</title>
</head>
<body>
<h1>HELLO <?= $_SESSION['nickname'] ?></h1>

<a href='logout.php'>Click here to log out</a>

</body>
</html>
